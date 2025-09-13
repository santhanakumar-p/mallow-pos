Dear Customer,

Order Details:
- Order ID: {{ $order->id }}
- Order Date: {{ $order->order_date }}
- Customer Email: {{ $order->customer_email }}

Order Items:
@foreach($order->orderItems as $item)
- {{ $item->product_name }} (Qty: {{ $item->quantity }}) - {{$item->formatted_total_amount }}
@endforeach

Summary:
- Total Amount: {{ $order->formatted_total_amount }}
