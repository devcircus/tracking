<?php

namespace App\Http\Actions\Artwork;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ArtComplete;
use PerfectOblivion\Actions\Action;
use App\Services\Artwork\BatchArtCompleteService;
use App\Http\Responders\Artwork\BatchArtCompleteResponder;

class BatchArtComplete extends Action
{
    /** @var \App\Http\Responders\Artwork\BatchArtCompleteResponder */
    private $responder;

    /** @var \App\Models\User */
    private $users;

    /**
     * Construct a new BatchArtComplete action.
     *
     * @param  \App\Http\Responders\Artwork\BatchArtCompleteResponder  $responder
     * @param  \App\Models\User  $users
     */
    public function __construct(BatchArtCompleteResponder $responder, User $users)
    {
        $this->responder = $responder;
        $this->users = $users;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $orders = BatchArtCompleteService::call($request->artwork);
        $this->users->superAdministrator()->notify(new ArtComplete(collect($orders), $request->user()));

        return $this->responder->withPayload($orders)->respond();
    }
}
