<?php

namespace App\Http\Actions\Artwork;

use App\Models\User;
use App\Models\Order;
use PerfectOblivion\Actions\Action;
use App\Services\Artwork\ArtCompleteService;
use App\Http\Responders\Artwork\ArtCompleteResponder;
use App\Notifications\ArtComplete as ArtCompleteNotification;

class ArtComplete extends Action
{
    /** @var \App\Http\Responders\Artwork\ArtCompleteResponder */
    private $responder;

    /** @var \App\Models\User */
    private $users;

    /**
     * Construct a new ArtComplete action.
     *
     * @param  \App\Http\Responders\Artwork\ArtCompleteResponder  $responder
     * @param  \App\Models\User  $users
     */
    public function __construct(ArtCompleteResponder $responder, User $users)
    {
        $this->responder = $responder;
        $this->users = $users;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Order $order)
    {
        if ($complete = ArtCompleteService::call($order)) {
            $this->users->superAdministrator()->notify(new ArtCompleteNotification($order, auth()->user()));
        }

        return $this->responder->withPayload($complete)->respond();
    }
}
