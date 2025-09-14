<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    protected $fillable = [
        'value',
        'count',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'count' => 'integer',
        ];
    }
}
