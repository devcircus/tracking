<?php

namespace App\Services\User;

use App\Models\User;
use App\Http\DTO\UserData;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\User\Validation\UpdateUserPasswordValidation;

class UpdateUserPasswordService
{
    use SelfCallingService;

    /** @var \App\Services\User\Validation\UpdateUserPasswordValidation */
    private $validator;

    /**
     * Construct a new UpdateUserPasswordService.
     *
     * @param  \App\Services\User\Validation\UpdateUserPasswordValidation
     */
    public function __construct(UpdateUserPasswordValidation $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\DTO\UserData  $data
     */
    public function run(User $user, UserData $data): User
    {
        $this->validator->validate($data->toArray());

        $updated = $user->updateUserPassword($data->only(['password']));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($updated)
            ->withProperties(['target' => $updated->name])
            ->log('changed password');

        return $updated;
    }
}
