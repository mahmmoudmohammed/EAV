<?php

namespace App\Http\Domains\Order\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
