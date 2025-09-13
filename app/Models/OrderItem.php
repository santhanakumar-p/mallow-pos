<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
        'tax_percentage',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'float',
            'quantity' => 'integer',
            'tax_percentage' => 'float',
            'total_amount' => 'float',
        ];
    }

    protected function formattedUnitPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => '₹'.number_format($this->unit_price),
        );
    }

    protected function formattedTotalAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => '₹'.number_format($this->total_amount),
        );
    }

    protected function formattedTaxPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->tax_percentage).'%',
        );
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
