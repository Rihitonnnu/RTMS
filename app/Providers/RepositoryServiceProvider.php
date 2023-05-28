<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\TargetTime\TargetTimeRepositoryInterface::class,
            \App\Repositories\TargetTime\TargetTimeRepository::class
        );
        $this->app->bind(
            \App\Repositories\WeeklyTime\WeeklyTimeRepositoryInterface::class,
            \App\Repositories\WeeklyTime\WeeklyTimeRepository::class
        );
        $this->app->bind(
            \App\Repositories\Rest\RestRepositoryInterface::class,
            \App\Repositories\Rest\RestRepository::class
        );
        $this->app->bind(
            \App\Repositories\Research\ResearchRepositoryInterface::class,
            \App\Repositories\Research\ResearchRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
