<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

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
        \Debugbar::disable();

        // Only Super Admin can access Log Viewer 
        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->role, [
                    UserRole::IS_SUPERADMIN,
                ]);
        });
    }
}
