<?php

namespace App\Http\Actions\Artwork;

use App\Models\Order;
use PerfectOblivion\Actions\Action;
use App\Services\Artwork\ArtCompleteService;
use App\Http\Responders\Artwork\ArtCompleteResponder;

class ArtComplete extends Action
{
    /** @var \App\Http\Responders\Artwork\ArtCompleteResponder */
    private $responder;

    /**
     * Construct a new ArtComplete action.
     *
     * @param  \App\Http\Responders\Artwork\ArtCompleteResponder  $responder
     */
    public function __construct(ArtCompleteResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Order $order)
    {
        $result = ArtCompleteService::call($order);

        return $this->responder->withPayload($result)->respond();
    }
}
