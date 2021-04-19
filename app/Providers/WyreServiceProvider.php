<?php

namespace App\Providers;

use App\Http\Controllers\Wyre\AccountController;
use App\Http\Controllers\Wyre\AuthTokenController;
use App\Repo\Wyre\WyreInterface;
use App\Repo\Wyre\WyreRepository;
use Illuminate\Support\ServiceProvider;

class WyreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(AuthTokenController::class)
            ->needs(WyreInterface::class)
            ->give(WyreRepository::class);
        $this->app->when(AccountController::class)
            ->needs(WyreInterface::class)
            ->give(WyreRepository::class);
    }
}
