<?php

namespace App\Http\Actions\Summary\Pdf;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Summary\ShowSummaryService;
use App\Http\Responders\Summary\Pdf\ShowSummaryPdfResponder;

class ShowSummaryPdf extends Action
{
    /** @var \App\Http\Responders\Summary\Pdf\ShowSummaryPdfResponder */
    private $responder;

    /**
     * Construct a new ShowSummaryPdf action.
     *
     * @param  \App\Http\Responders\Summary\Pdf\ShowSummaryPdfResponder  $responder
     */
    public function __construct(ShowSummaryPdfResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request)
    {
        return $this->responder->withPayload(ShowSummaryService::call(
            $request->only(['date']),
        ))->withRequest($request)
        ->respond();
    }
}
