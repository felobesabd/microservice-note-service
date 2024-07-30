<?php

namespace App\Providers;

use App\Redis\Imp\RedisPubSub;
use App\Redis\IRedisPubSub;
use App\Repository\Imp\NoteRepo;
use App\Repository\INoteRepo;
use App\Service\Imp\NoteService;
use App\Service\INoteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(INoteRepo::class, NoteRepo::class);
        $this->app->bind(INoteService::class, NoteService::class);
        $this->app->bind(IRedisPubSub::class, RedisPubSub::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
