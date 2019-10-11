<?php

namespace App\Services\User;

use App\Models\User;
use PerfectOblivion\Services\Traits\SelfCallingService;

class RestoreUserService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     */
    public function run(User $user): User
    {
        $restored = $user->restoreUser();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($restored)
            ->withProperties(['target' => $restored->name])
            ->log('user restored');

        return $restored;
    }
}
