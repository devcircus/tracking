<?php

namespace App\Http\Responders\Voucher;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ListVouchersForArtistsResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Vouchers/Index', [
            'results' => $this->payload['reports'],
            'date' => $this->payload['date'],
            'timestamp' => $this->payload['timestamp'],
        ]);
    }
}
