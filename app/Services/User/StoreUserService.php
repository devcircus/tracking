<?php

namespace App\Services\User;

use App\Models\User;
use App\Http\DTO\UserData;
use App\Services\User\Validation\StoreUserValidation;
use PerfectOblivion\Services\Traits\SelfCallingService;

class StoreUserService
{
    use SelfCallingService;

    /** @var \App\Services\User\Validation\StoreUserValidation */
    private $validator;

    /** @var \App\Models\User */
    private $users;

    /**
     * Construct a new StoreUserService.
     *
     * @param  \App\Services\User\Validation\StoreUserValidation  $validator
     * @param  \App\Models\User  $users
     */
    public function __construct(StoreUserValidation $validator, User $users)
    {
        $this->validator = $validator;
        $this->users = $users;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Http\DTO\UserData  $user
     */
    public function run(UserData $user): User
    {
        $this->validator->validate($user->toArray());

        $created = $this->users->createUser($user->only(['name', 'email', 'password', 'is_admin', 'is_artist']));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($created)
            ->withProperties(['target' => $created->name])
            ->log('user created');

        return $created;
    }
}
