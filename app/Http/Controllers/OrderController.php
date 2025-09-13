<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Mail\OrderInvoiceMail;
use App\Models\Denomination;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function create(): View
    {
        $products = Product::select('id', 'name', 'product_code', 'price', 'stock', 'tax')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('orders.create', compact('products'));
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {

        DB::beginTransaction();

        try {
            $order = new Order;
            $order->customer_email = $request->customer_email;
            $order->order_date = now()->toDateString();
            $order->save();

            $totalAmount = 0;

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['product_id']);
                $quantity = $productData['quantity'];

                $unitPrice = $product->price;
                $subtotal = $unitPrice * $quantity;
                $taxAmount = ($subtotal * $product->tax) / 100;
                $itemTotal = $subtotal + $taxAmount;

                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->product_name = $product->name;
                $orderItem->unit_price = $unitPrice;
                $orderItem->quantity = $quantity;
                $orderItem->tax_percentage = $product->tax;
                $orderItem->total_amount = $itemTotal;
                $orderItem->save();

                $totalAmount += $itemTotal;

                $product->stock -= $quantity;
                $product->save();
            }

            foreach ($request->denominations as $value => $count) {
                if ($count > 0) {
                    $denomination = Denomination::where('value', $value)->first();
                    if ($denomination) {
                        $denomination->count += $count;
                        $denomination->save();
                    }
                }
            }

            $balanceAmount = $request->amount_paid - $totalAmount;
            $denominations = [500, 200, 100, 50, 20, 10, 5, 2, 1];

            foreach ($denominations as $denominationValue) {
                $count = floor($balanceAmount / $denominationValue);
                if ($count > 0) {
                    $denomination = Denomination::where('value', $denominationValue)->first();
                    if ($denomination && $denomination->count >= $count) {
                        $denomination->count -= $count;
                        $denomination->save();
                        $balanceAmount -= $count * $denominationValue;
                    }
                }
            }

            $order->total_amount = $totalAmount;
            $order->save();

            DB::commit();

            Mail::to($order->customer_email)->send(new OrderInvoiceMail($order));

            return redirect()->route('orders.details', $order->id)
                ->with('success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function index(): View
    {
        $orders = Order::with('orderItems')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function orderDetails(int $id): View
    {
        $order = Order::findOrFail($id);

        return view('orders.details', compact('order'));
    }
}
