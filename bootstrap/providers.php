<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Http\Domains\User\UserServiceProvider::class,
    App\Http\Domains\Project\ProjectServiceProvider::class,
    App\Http\Domains\EAV\AttributeServiceProvider::class,
];
