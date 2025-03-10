<?php

namespace App\Http\Domains\Order\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'changed_by',
        'notes'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
