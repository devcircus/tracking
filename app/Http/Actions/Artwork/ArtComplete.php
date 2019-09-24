<?php

namespace App\Http\Actions\Artwork;

use App\Models\User;
use App\Models\Order;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Artwork\ArtCompleteService;
use App\Http\Responders\Artwork\ArtCompleteResponder;
use App\Services\Notifications\ArtworkCompleteNotificationService;

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
     *
     * @param  \App\Models\Order  $order
     */
    public function __invoke(Order $order): RedirectResponse
    {
        if ($complete = ArtCompleteService::call($order)) {
            ArtworkCompleteNotificationService::call($order, auth()->user());
        }

        return $this->responder->withPayload($complete)->respond();
    }
}
