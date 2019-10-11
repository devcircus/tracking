<?php

namespace App\Http\Responders\Summary\Pdf;

use PDF;
use Illuminate\Http\Response;
use PerfectOblivion\Responder\Responder;

class ShowSummaryPdfResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        $pdf = PDF::loadView('pdf.summary', [
            'summary' => $this->payload,
            'date' => display_date($this->request->date),
            'timestamp' => $this->request->timestamp,
        ])->setPaper('letter', 'landscape');

        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.'summary'.'"',
        ]);
    }
}
