<?php

namespace App\Providers;

use App\Repositories\EloquentRoomRepository;
use App\Repositories\RoomRepositoryInterface;
use App\Services\RoomService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RoomRepositoryInterface::class, EloquentRoomRepository::class);

        $this->app->bind(RoomService::class, static function ($app) {
            return new RoomService($app->make(RoomRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}