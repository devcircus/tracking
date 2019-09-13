<?php

namespace App\Http\Responders\Color\Pdf;

use PDF;
use PerfectOblivion\Responder\Responder;

class ShowPrinterColorsPdfResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        $pdf = PDF::loadView('pdf.colors', $this->payload)->setPaper('letter', 'landscape');

        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename={$this->payload['printer']['name']}-{$this->payload['printer']['ink']['type']}.pdf",
            // 'Content-Disposition' => 'inline; filename="'.$this->payload['printer']['name'].'"',
        ]);
    }
}
