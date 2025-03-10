<?php

namespace App\Http\Domains\Order;


use App\Http\Controllers\Controller;
use App\Http\Domains\Order\Contract\OrderInterface;
use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Request\ApprovalRequest;
use App\Http\Domains\Order\Resource\OrderResource;
use App\Http\Domains\Order\Service\ApprovalService;


class ApprovalController extends Controller
{
    public function __construct(
        private OrderInterface $repository,
        private ApprovalService $service)
    {
    }
    public function pending()
    {
        //TODO::PendingOrders
        $orders = $this->repository->getPendingOrders();
        $orders = $this->repository->load($orders, ['items', 'history']);

        return $this->responseResource(OrderResource::make($orders), status: 201);
    }

    public function approve(ApprovalRequest $request, Order $order)
    {
        $order = $this->service->approveOrder($order, $request->validated());
        $order = $this->repository->load($order, ['items', 'history']);

        return $this->responseResource(OrderResource::make($order));
    }

    public function reject(Order $order)
    {
        $order = $this->service->rejectOrder($order);
        $order = $this->repository->create($order,);

        return $this->responseResource(OrderResource::make($order));
    }
}
