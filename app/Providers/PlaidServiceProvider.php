<?php

namespace App\Providers;

use App\Http\Controllers\Plaid\AccountController;
use App\Http\Controllers\Plaid\AssetReportController;
use App\Http\Controllers\Plaid\AuthDetailsController;
use App\Http\Controllers\Plaid\IdentityController;
use App\Http\Controllers\Plaid\InstitutionController;
use App\Http\Controllers\Plaid\InvestmentController;
use App\Http\Controllers\Plaid\ItemController;
use App\Http\Controllers\Plaid\LiabilityController;
use App\Http\Controllers\Plaid\PlaidTestingController;
use App\Http\Controllers\Plaid\PublicTokenController;
use App\Http\Controllers\Plaid\TransactionController;
use App\Http\Controllers\Plaid\DwollaController;
use App\Repo\Plaid\PlaidInterface;
use App\Repo\Plaid\PlaidRepository;
use Illuminate\Support\ServiceProvider;

class PlaidServiceProvider extends ServiceProvider
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
        $this->app->when(AssetReportController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(IdentityController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(AccountController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(ItemController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(PlaidTestingController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(PublicTokenController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(TransactionController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(InvestmentController::class)
            ->needs(PlaidInterface::class)
            ->give(PlaidRepository::class);

        $this->app->when(AuthDetailsController::class)
                  ->needs(PlaidInterface::class)
                  ->give(PlaidRepository::class);

        $this->app->when(LiabilityController::class)
                  ->needs(PlaidInterface::class)
                  ->give(PlaidRepository::class);

        $this->app->when(InstitutionController::class)
                  ->needs(PlaidInterface::class)
                  ->give(PlaidRepository::class);

        $this->app->when(DwollaController::class)
                  ->needs(PlaidInterface::class)
                  ->give(PlaidRepository::class);
    }
}
