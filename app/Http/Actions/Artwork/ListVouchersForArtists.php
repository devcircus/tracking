<?php

namespace App\Http\Actions\Artwork;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Artwork\ListVouchersForArtistsService;
use App\Http\Responders\Artwork\ListVouchersForArtistsResponder;

class ListVouchersForArtists extends Action
{
    /** @var \App\Http\Responders\Artworks\ListVouchersForArtistsResponder */
    private $responder;

    /**
     * Construct a new ListVouchersForArtists action.
     *
     * @param  \App\Http\Responders\Artworks\ListVouchersForArtistsResponder  $responder
     */
    public function __construct(ListVouchersForArtistsResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        $vouchers = ListVouchersForArtistsService::call();

        return $this->responder->withPayload($vouchers)->respond();
    }
}
