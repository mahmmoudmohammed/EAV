<?php

declare(strict_types=1);

namespace App\Http\Domains\Order;

use App\Http\Domains\Order\Contract\OrderInterface;
use App\Http\Domains\Order\Repository\OrderRepository;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderInterface::class, OrderRepository::class);
    }

    public function boot()
    {
    }
}
