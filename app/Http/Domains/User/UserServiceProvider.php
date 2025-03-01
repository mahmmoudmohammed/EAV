<?php

declare(strict_types=1);

namespace App\Http\Domains\User;


use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        Passport::tokensExpireIn(now()->addDays(10));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(3));
    }
}
