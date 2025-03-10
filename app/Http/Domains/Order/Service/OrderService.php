<?php

namespace App\Http\Domains\Order\Service;

use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Model\OrderLog;
use App\Http\Domains\Order\Model\OrderStatusEnum;
use App\Http\Domains\Order\Model\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    /**
     * Generate a unique order number.
     *
     * @return string
     */
    public function generateOrderNumber()
    {
        return DB::transaction(function () {
            $lastOrder = Order::orderBy('id', 'desc')->first();
            $baseNumber = 'ORD-' . date('Ymd') . '-';
            $nextNumber = 1;
            if ($lastOrder) {
                preg_match('/ORD-\d{8}-(\d+)/', $lastOrder->order_number, $matches);

                if (isset($matches[1])) {
                    $nextNumber = intval($matches[1]) + 1;
                } else {
                    $nextNumber = 1;
                }
            }
            return $baseNumber . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }, 3);
    }

    /**
     * Create a new order with items.
     *
     * @param array $orderData
     * @return Order
     */
    public function createOrder(array $orderData)
    {
        return DB::transaction(function () use ($orderData) {
            $orderData['user_id'] = auth()->user()->id;
            $orderData['order_number'] = $this->generateOrderNumber();
            $orderData['status'] = OrderStatusEnum::DRAFT;
            $order = Order::create($orderData);

            $totalAmount = 0;

            foreach ($orderData['items'] as $itemData) {
                $item = Product::find($itemData['product_id']);
                if(!$item){
                    continue;
                }
                $subtotal = $itemData['quantity'] * $item->price;
                $totalAmount += $subtotal;

                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $item->price,
                    'subtotal' => $subtotal
                ]);
            }
            $order->total_amount = $totalAmount;
            $order->save();
            $this->addHistory($order, OrderStatusEnum::DRAFT, 'Order created');

            // Check if order requires approval
            if ($order->requiresApproval()) {
                $this->submitForApproval($order);
            } else {
                $this->approveOrder($order);
            }

            return $order->fresh(['items', 'history']);
        });
    }

    public function submitForApproval(Order $order)
    {
        if (!$order->canBeModified()) {
            throw new Exception('This order cannot be modified');
        }

        $order->status = OrderStatusEnum::PENDING_APPROVAL;
        $order->save();

        $this->addHistory($order, OrderStatusEnum::PENDING_APPROVAL, 'Order submitted for approval');

        return $order->fresh();
    }

    public function addHistory(Order $order, OrderStatusEnum $status, string $notes = null)
    {
        return OrderLog::create([
            'order_id' => $order->id,
            'status' => $status,
            'changed_by' => auth()->user() ? auth()->user()->name : 'Console',
            'notes' => $notes
        ]);
    }

    /**
     * Calculate the order total.
     *
     * @param Order $order
     * @return float
     */
    public function calculateTotal(Order $order)
    {
        return $order->items->sum('subtotal');
    }
}
