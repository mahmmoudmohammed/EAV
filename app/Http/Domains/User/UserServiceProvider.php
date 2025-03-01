<?php

declare(strict_types=1);

namespace App\Http\Domains\User;

use App\Http\Domains\User\Contract\AuthInterface;
use App\Http\Domains\User\Contract\UserInterface;
use App\Http\Domains\User\Repository\AuthRepository;
use App\Http\Domains\User\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind( UserInterface::class, UserRepository::class);
        $this->app->bind( AuthInterface::class, AuthRepository::class);
    }

    public function boot()
    {
        Passport::tokensExpireIn(now()->addDays(10));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(3));
    }
}
