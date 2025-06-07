<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Memaksa semua URL menggunakan https jika environment adalah 'production'
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // fungsi menampilkan pengguna acak di sidebar
        View::composer('layouts.app', function ($view) {
            $allUsers = User::all();
            $randomUsersForSidebar = $allUsers->shuffle()->take(10);
            $view->with('randomUsersForSidebar', $randomUsersForSidebar);
        });
    }
}