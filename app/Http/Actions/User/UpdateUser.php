<?php

namespace App\Http\Actions\User;

use App\Models\User;
use App\Http\DTO\UserData;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\User\UpdateUserService;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Services\User\UpdateUserPasswordService;
use App\Http\Responders\User\UpdateUserResponder;

class UpdateUser extends Action
{
    /** @var \App\Http\Responders\User\UpdateUserResponder */
    private $responder;

    /** @var \Illuminate\Contracts\Auth\Access\Gate */
    private $gate;

    /**
     * Construct a new UpdateUser action.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @param  \App\Http\Responders\User\UpdateUserResponder  $responder
     */
    public function __construct(Gate $gate, UpdateUserResponder $responder)
    {
        $this->gate = $gate;
        $this->responder = $responder;
    }

    /**
     * Update a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     */
    public function __invoke(Request $request, User $user): RedirectResponse
    {
        if (! $this->gate->allows('update-user', $user)) {
            return redirect()->back()->with(['warning' => 'You do not have permission to edit this user.']);
        }

        $updated = UpdateUserService::call($user, UserData::fromArray($request->only(['id', 'name', 'email', 'is_admin', 'is_artist'])));

        if ($request->password) {
            UpdateUserPasswordService::call($user, UserData::fromArray($request->only(['password'])));
        }

        return $this->responder->withPayload($updated)->respond();
    }
}
