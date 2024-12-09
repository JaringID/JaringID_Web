<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Filament\Widgets\UserProfile;
use App\Filament\Resources\UserResource;

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
            if (Auth::check() && Auth::user()->role !== 'owner' && Auth::user()->role !== 'farm_manager' && Auth::user()->role !== 'technician' && Auth::user()->role !== 'employee') {
                abort(403, 'Akses Ditolak Wak');
            }
            Filament::registerWidgets([
                UserProfile::class,
            ]);
            Filament::registerResources([
                UserResource::class,
            ]);
            Filament::registerRenderHook(
                'auth-check',
                function () {
                    if (!Auth::check()) {
                        return redirect()->route('login');
                    }
                }
            );
            
           
        });

        
    }

    
}
