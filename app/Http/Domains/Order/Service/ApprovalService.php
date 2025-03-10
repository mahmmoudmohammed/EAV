<?php

namespace App\Http\Domains\Order\Service;

use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Model\OrderStatusEnum;
use Exception;
use Illuminate\Support\Facades\DB;
class ApprovalService
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function approveOrder(Order $order, string $notes = null)
    {
        return $this->orderService->approveOrder($order, $notes);
    }

    public function rejectOrder(Order $order, string $notes = null)
    {
        return DB::transaction(function () use ($order, $notes) {
            if (!$order->isPendingApproval()) {
                throw new Exception('Only orders with pending approval status can be rejected');
            }

            $order->status = OrderStatusEnum::REJECTED;
            $order->save();

            $this->orderService->addHistory($order, OrderStatusEnum::REJECTED, $notes ?: 'Order rejected');

            return $order->fresh();
        });
    }
}
