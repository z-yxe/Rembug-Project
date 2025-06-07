<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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

    // fungssi menampilkan pengguna acak di sidebar
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $allUsers = User::all();
            $randomUsersForSidebar = $allUsers->shuffle()->take(10);
            $view->with('randomUsersForSidebar', $randomUsersForSidebar);
        });
    }
}
