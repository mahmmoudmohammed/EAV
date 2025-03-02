<?php

declare(strict_types=1);

namespace App\Http\Domains\EAV;

use App\Http\Domains\EAV\Contract\AttributeInterface;
use App\Http\Domains\EAV\Repository\AttributeRepository;
use Illuminate\Support\ServiceProvider;

class AttributeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AttributeInterface::class, AttributeRepository::class);
    }

    public function boot()
    {
    }
}
