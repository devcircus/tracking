<?php

namespace App\Http\Actions\Summary;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Summary\ShowSummaryService;
use App\Http\Responders\Summary\ShowSummaryResponder;

class ShowSummary extends Action
{
    /** @var \App\Http\Responders\Summary\ShowSummaryResponder */
    private $responder;

    /**
     * Construct a new ShowSummary action.
     *
     * @param  \App\Http\Responders\Summary\ShowSummaryResponder  $responder
     */
    public function __construct(ShowSummaryResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request)
    {
        return $this->responder->withPayload(
            ShowSummaryService::call(
                $request->only(['date']),
            ))->withRequest($request)
            ->respond();
    }
}
