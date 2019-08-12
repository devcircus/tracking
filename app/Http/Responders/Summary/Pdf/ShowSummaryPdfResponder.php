<?php

namespace App\Http\Responders\Summary\Pdf;

use PDF;
use PerfectOblivion\Responder\Responder;

class ShowSummaryPdfResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
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
