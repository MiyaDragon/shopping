<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param AdminUser $adminUser
     * @return bool
     */
    public function viewAny(AdminUser $adminUser): bool
    {
        return $adminUser->is_owner;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param AdminUser $adminUser
     * @return bool
     */
    public function view(AdminUser $adminUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param AdminUser $adminUser
     * @return bool
     */
    public function create(AdminUser $adminUser): bool
    {
        return $adminUser->is_owner;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param AdminUser $adminUser
     * @return bool
     */
    public function update(AdminUser $adminUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param AdminUser $adminUser
     * @return bool
     */
    public function delete(AdminUser $adminUser): bool
    {
        return $adminUser->is_owner;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdminUser  $adminUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AdminUser $adminUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdminUser  $adminUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AdminUser $adminUser)
    {
        //
    }
}
