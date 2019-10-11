<?php

namespace App\Http\Actions\Pdf;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Pdf\ShowPdfService;
use App\Http\Responders\Pdf\ShowPdfResponder;

class ShowPdf extends Action
{
    /** @var \App\Http\Responders\Pdf\ShowPdfResponder */
    private $responder;

    /**
     * Construct a new ShowPdf action.
     *
     * @param  \App\Http\Responders\Pdf\ShowPdfResponder  $responder
     */
    public function __construct(ShowPdfResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $payload = [
            'report' => ShowPdfService::call($request->only(['date', 'timestamp']), $request->route('type')),
            'type' => $request->route('type'),
            'date' => $request->date,
            'timestamp' => $request->timestamp,
        ];

        return $this->responder->withPayload($payload);
    }
}
