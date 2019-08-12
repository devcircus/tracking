<?php

namespace App\Http\Actions\Report;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Report\ShowIndividualReportService;
use App\Http\Responders\Report\ShowIndividualReportResponder;

class ShowIndividualReport extends Action
{
    /** @var \App\Http\Responders\Report\ShowIndividualReportResponder */
    private $responder;

    /**
     * Construct a new ShowIndividualReport action.
     *
     * @param  \App\Http\Responders\Report\ShowIndividualReportResponder  $responder
     */
    public function __construct(ShowIndividualReportResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        return $this->responder->withPayload([
            'report' => ShowIndividualReportService::call([
                'date' => $request->date,
                'type' => $request->route('type'),
            ]),
            'timestamp' => request()->timestamp,
            'date' => request()->date,
            'type' => $request->route('type'),
        ])->respond();
    }
}
