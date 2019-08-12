<?php

namespace App\Http\Actions\Report;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Report\ShowComprehensiveReportService;
use App\Http\Responders\Report\ShowComprehensiveReportResponder;

class ShowComprehensiveReport extends Action
{
    /** @var \App\Http\Responders\Report\ShowComprehensiveReportResponder */
    private $responder;

    /**
     * Construct a new ShowComprehensiveReport action.
     *
     * @param  \App\Http\Responders\Report\ShowComprehensiveReportResponder  $responder
     */
    public function __construct(ShowComprehensiveReportResponder $responder)
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
        return $this->responder->withPayload([
            'results' => ShowComprehensiveReportService::call($request->date),
            'date' => $request->date,
            'timestamp' => $request->timestamp,
        ])->respond();
    }
}
