<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'product_code',
        'price',
        'stock',
        'tax',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'tax' => 'decimal:2',
        ];
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => '₹'.number_format($this->price),
        );
    }

    protected function formattedTax(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->tax).'%',
        );
    }
}
