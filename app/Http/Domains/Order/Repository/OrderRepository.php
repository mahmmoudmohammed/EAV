<?php

namespace App\Http\Domains\Order\Repository;

use App\Http\Domains\Order\Contract\OrderInterface;
use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Service\OrderService;
use App\Http\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderInterface
{
    public function __construct(private OrderService $orderService)
    {
    }

    protected function model(): string
    {
        return Order::class;
    }

    /**
     * @throws \Exception
     */
    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {
            $model = $this->orderService->createOrder($data);
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public function list(Builder $builder): LengthAwarePaginator
    {
        return parent::list($builder->with(['items', 'history']));
    }

    public function getHistory(Order $order, array|string $relations = null)
    {
        if($relations)
            $order->load($relations);
        return $order->history()->orderBy('created_at', 'desc');
    }
    public function load(Order $order, array|string $relations): Order
    {
        return $order->load($relations);
    }
}
