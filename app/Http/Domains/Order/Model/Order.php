<?php

namespace App\Http\Domains\Order\Model;

use App\Http\Domains\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'total_amount',
        'user_id',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function history()
    {
        return $this->hasMany(OrderLog::class);
    }

    public function requiresApproval(): bool
    {
        return $this->total_amount >= 1000;
    }

    public function isApproved(): bool
    {
        return $this->status === OrderStatusEnum::APPROVED;
    }

    public function isPendingApproval(): bool
    {
        return $this->status === OrderStatusEnum::PENDING_APPROVAL;
    }

    public function isRejected(): bool
    {
        return $this->status === OrderStatusEnum::REJECTED;
    }

    public function isDraft(): bool
    {
        return $this->status === OrderStatusEnum::DRAFT;
    }

    public function canBeModified(): bool
    {
        return !$this->isApproved();
    }
}
