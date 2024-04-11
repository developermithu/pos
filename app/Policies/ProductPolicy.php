<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isCashier();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): void
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): void
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): void
    {
        //
    }

    /**
     * Determine whether the user can bulk delete the model.
     */
    public function bulkDelete(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): void
    {
        //
    }

    // ========== Point of Sale Managment =========== //

    public function posManagement(User $user): void
    {
        //
    }
}
