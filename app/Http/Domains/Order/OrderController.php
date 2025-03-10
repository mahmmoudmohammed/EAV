<?php

namespace App\Http\Domains\Order;


use App\Http\Controllers\Controller;
use App\Http\Domains\Order\Contract\OrderInterface;
use App\Http\Domains\Order\Filter\OrderFilter;
use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Request\CreateOrderRequest;
use App\Http\Domains\Order\Resource\OrderResource;
use App\Http\Domains\Order\Service\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function __construct(
        private OrderInterface $repository,
        private OrderService $service)
    {
    }
    public function store(CreateOrderRequest $request)
    {
        $order = $this->repository->create($request->validated());
        $order = $this->repository->load($order, ['items', 'history']);

        return $this->responseResource(OrderResource::make($order), status: 201);
    }

    public function show(Order $order): OrderResource|JsonResponse
    {
        $order = $this->repository->getById($order->id);
        return $this->responseResource(OrderResource::make($order->load(['items', 'history'])));
    }

    public function index(Request $request): JsonResponse
    {
        $query = OrderFilter::apply($request);
        $order = $this->repository->list($query);

        return $this->responseResource(
            OrderResource::collection($order)
        );
    }

    public function submitForApproval(Order $order)
    {
        $order = $this->service->submitForApproval($order);
        $order = $this->repository->load($order, ['items', 'history']);

        return $this->responseResource(OrderResource::make($order));
    }
    public function history(Order $order): JsonResponse
    {
        $orderWithHistory = $this->repository->getHistory($order,['items']);
        return $this->responseResource(OrderResource::make($orderWithHistory));

    }

}
