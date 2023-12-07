<?php

namespace App\Providers;


use App\Enums\UserRole;
use App\Models\Product;
use App\Models\User;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Laravel can automatically discover policies 
        // if policy follow the standard Laravel naming conventions.

        // Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Grant all permissions for superadmins
        Gate::before(function (User $user, string $ability) {
            if ($user->isSuperadmin()) {
                return true;
            }
        });
    }
}
