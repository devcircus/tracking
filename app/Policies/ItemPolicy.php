<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    public const ADMINISTER = 'administerItems';
    public const DELETE = 'deleteItem';
    public const RESTORE = 'restoreItem';
    public const UPDATE = 'updateItem';
    public const CREATE = 'createItem';

    use HandlesAuthorization;

    /**
     * Can a user administer inventory items?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function administerItems(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }

    /**
     * Can a user delete an item?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function deleteItem(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }

    /**
     * Can a user restore an item?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function restoreItem(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }

    /**
     * Can a user update an item?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function updateItem(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }

    /**
     * Can a user create an item?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function createItem(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }
}
