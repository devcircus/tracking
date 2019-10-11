<?php

namespace App\Http\Actions\User;

use App\Models\User;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\User\DeleteUserService;
use App\Http\Responders\User\DeleteUserResponder;

class DeleteUser extends Action
{
    /** @var \App\Http\Responders\User\DeleteUserResponder */
    private $responder;

    /**
     * Construct a new DeleteUser action.
     *
     * @param  App\Http\Responders\User\DeleteUserResponder  $responder
     */
    public function __construct(DeleteUserResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action to delete a user.
     *
     * @param  \App\Models\User  $user
     */
    public function __invoke(User $user): RedirectResponse
    {
        $deleted = DeleteUserService::call($user);

        return $this->responder->withPayload($deleted)->respond();
    }
}
