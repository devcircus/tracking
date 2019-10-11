<?php

namespace App\Http\Responders\Color\Pdf;

use PDF;
use Illuminate\Http\Response;
use PerfectOblivion\Responder\Responder;

class ShowPrinterColorsPdfResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        $pdf = PDF::loadView('pdf.colors', $this->payload)->setPaper('letter', 'landscape');

        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename={$this->payload['printer']['name']}-{$this->payload['printer']['ink']['type']}.pdf",
        ]);
    }
}
