<?php

namespace App\Http\Actions\Artwork;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Artwork\ListArtworkVouchersService;
use App\Http\Responders\Artwork\ListArtworkVouchersResponder;

class ListArtworkVouchers extends Action
{
    /** @var \App\Http\Responders\Artworks\ListArtworkVouchersResponder */
    private $responder;

    /**
     * Construct a new ListArtworkVouchers action.
     *
     * @param  \App\Http\Responders\Artworks\ListArtworkVouchersResponder  $responder
     */
    public function __construct(ListArtworkVouchersResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        $results = ListArtworkVouchersService::call();

        return $this->responder->withPayload($results)->respond();
    }
}
