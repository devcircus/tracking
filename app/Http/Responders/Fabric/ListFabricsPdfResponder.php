<?php

namespace App\Http\Responders\Fabric;

use PDF;
use PerfectOblivion\Responder\Responder;

class ListFabricsPdfResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        $pdf = PDF::loadView('pdf.fabrics', $this->payload)->setPaper('letter', 'landscape');

        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename=fabrics.pdf',
        ]);
    }
}
