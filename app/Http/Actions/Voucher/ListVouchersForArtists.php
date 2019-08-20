<?php

namespace App\Http\Actions\Voucher;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Voucher\ListVouchersForArtistsService;
use App\Http\Responders\Voucher\ListVouchersForArtistsResponder;

class ListVouchersForArtists extends Action
{
    /** @var \App\Http\Responders\Vouchers\ListVouchersForArtistsResponder */
    private $responder;

    /**
    * Construct a new ListVouchersForArtists action.
    *
    * @param  \App\Http\Responders\Vouchers\ListVouchersForArtistsResponder  $responder
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
