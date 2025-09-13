<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_email',
        'order_date',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'total_amount' => 'float',
        ];
    }

    protected function formattedTotalAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => '₹'.number_format($this->total_amount),
        );
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
