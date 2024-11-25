<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Filament::serving(function () {
            // Hanya izinkan pengguna dengan role 'owner' untuk mengakses dashboard Filament
            if (Auth::check() && Auth::user()->role !== 'owner' && Auth::user()->role !== 'farm_manager' ) {
                abort(403, 'Akses Ditolak Wak');
            }
        });

        
    }

    
}
