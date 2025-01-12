<?php

namespace App\Providers;

use App\Models\Kolam;
use Filament\Facades\Filament;
use App\Observers\TambakObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Kolam::observe(TambakObserver::class);
    }
}
