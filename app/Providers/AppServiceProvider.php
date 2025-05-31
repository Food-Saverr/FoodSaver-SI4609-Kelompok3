<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user && $user->Role_Pengguna !== 'Admin' && method_exists($user, 'notifications')) {
                $notifications = $user->notifications()->latest()->paginate(5);
                $view->with('notifications', $notifications);
            } else {
                $view->with('notifications', collect());
            }
        });
    }
}
