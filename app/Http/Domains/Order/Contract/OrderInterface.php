<?php

namespace App\Http\Domains\Order\Contract;

use App\Http\Domains\Order\Model\Order;
use App\Http\Repository\BaseCrudInterface;

interface OrderInterface extends BaseCrudInterface
{
    public function load(Order $order, array|string $relations): Order;
}
