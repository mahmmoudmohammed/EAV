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

    /**
     * Approve an order.
     *
     * @param Order $order
     * @param string $notes
     * @return Order
     */
    public function approveOrder(Order $order, string $notes = null)
    {
        return DB::transaction(function () use ($order, $notes) {
            if (!$order->isPendingApproval()) {
                throw new Exception('Only orders with pending approval status can be approved');
            }

            $order->status = OrderStatusEnum::APPROVED;
            $order->save();

            $this->orderService->addHistory($order, OrderStatusEnum::APPROVED, $notes ?: 'Order approved');

            return $order->fresh();
        });
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
