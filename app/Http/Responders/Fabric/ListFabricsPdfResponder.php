<?php

namespace App\Http\Responders\Fabric;

use PDF;
use Illuminate\Http\Response;
use PerfectOblivion\Responder\Responder;

class ListFabricsPdfResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        $pdf = PDF::loadView('pdf.fabrics', $this->payload)->setPaper('letter', 'landscape');

        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename=fabrics.pdf',
        ]);
    }
}
