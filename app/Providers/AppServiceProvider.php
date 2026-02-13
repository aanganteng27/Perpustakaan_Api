<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);

        // Otomatis migrate kalau bukan di laptop (di Railway)
        if (config('app.env') !== 'local') {
            try {
                Artisan::call('migrate --force');
            } catch (\Exception $e) {
                // Biar nggak crash kalau database belum siap
            }
        }
    }
}