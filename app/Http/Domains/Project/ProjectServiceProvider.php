<?php

declare(strict_types=1);

namespace App\Http\Domains\Project;

use App\Http\Domains\Project\Contract\ProjectInterface;
use App\Http\Domains\Project\Repository\ProjectRepository;
use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
    }

    public function boot()
    {
    }
}
