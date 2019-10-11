<?php

namespace App\Http\Actions\User;

use Inertia\Response;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\User\ListUsersService;
use App\Http\Responders\User\ListUsersResponder;

class ListUsers extends Action
{
    /** @var \App\Http\Responders\User\ListUsersResponder */
    private $responder;

    /**
     * Construct a new ListUsers action.
     *
     * @param  \App\Http\Responders\User\ListUsersResponder  $responder
     */
    public function __construct(ListUsersResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * List the users.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): Response
    {
        return $this->responder->withPayload([
            'filters' => $request->all('search', 'trashed'),
            'users' => ListUsersService::call($request->only('search', 'trashed')),
        ])->respond();
    }
}
