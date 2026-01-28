<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('layouts.admin', function ($view) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user) {
                // Fetch unread notifications
                $notifications = \App\Models\Notification::where('user_id', $user->id)
                                ->where('status', 'unread')
                                ->orderBy('created_at', 'desc')
                                ->get();
                $view->with('unreadNotifications', $notifications);
            } else {
                $view->with('unreadNotifications', collect([]));
            }
        });
    }
}
