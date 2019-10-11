<?php

namespace App\Http\Responders\Pdf;

use PDF;
use Illuminate\Http\Response;
use PerfectOblivion\Responder\Responder;

class ShowPdfResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        $pdf = PDF::loadView('pdf.main', $this->payload)->setPaper('letter', 'landscape');

        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$this->payload['type'].'"',
        ]);
    }
}
