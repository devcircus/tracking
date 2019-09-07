<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryPolicy
{
    public const ADMINISTER = 'administerTags';
    public const DELETE = 'deleteTag';
    public const FINISH = 'finishTag';
    public const RESTORE = 'restoreTag';
    public const ACTIVATE = 'activateTag';

    use HandlesAuthorization;

    /**
     * Can a user administer inventory tags?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function administerTags(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }

    /**
     * Can a user delete a Tag from inventory?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function deleteTag(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }

    /**
     * Can a user restore a Tag to inventory?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function restoreTag(User $user)
    {
        if (! $user->is_admin) {
            return false;
        }

        return true;
    }

    /**
     * Can a user finish a Tag in inventory?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function finishTag(User $user)
    {
        return true;
    }

    /**
     * Can a user activate a Tag from inventory?
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function activateTag(User $user)
    {
        return true;
    }
}
