<?php

namespace App\Services\User;

use App\Models\User;
use PerfectOblivion\Services\Traits\SelfCallingService;

class DeleteUserService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\User  $user
     *
     * @return \App\Models\User
     */
    public function run(User $user)
    {
        $deleted = $user->deleteUser();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => $deleted->name])
            ->log('deleted user');

        return $deleted;
    }
}
