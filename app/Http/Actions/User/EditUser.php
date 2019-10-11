<?php

namespace App\Http\Actions\User;

use App\Models\User;
use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\User\EditUserResponder;

class EditUser extends Action
{
    /** @var \App\Http\Responders\User\EditUserResponder */
    private $responder;

    /**
     * Construct a new EditUser action.
     *
     * @param  \App\Http\Responders\User\EditUserResponder  $responder
     */
    public function __construct(EditUserResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Show the form to edit a user.
     *
     * @param  \App\Models\User  $user
     */
    public function __invoke(User $user): Response
    {
        return $this->responder->withPayload($user)->respond();
    }
}
