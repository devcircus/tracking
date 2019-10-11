<?php

namespace App\Http\Actions\Order;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Order\BatchUpdateInfoService;
use App\Http\Responders\Order\BatchUpdateInfoResponder;

class BatchUpdateInfo extends Action
{
    /** @var \App\Http\Responders\Order\BatchUpdateInfoResponder */
    private $responder;

    /**
    * Construct a new UpdateInfo action.
    *
    * @param  \App\Http\Responders\Order\BatchUpdateInfoResponder  $responder
    */
    public function __construct(BatchUpdateInfoResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $result = BatchUpdateInfoService::call($request->info, $request->date);

        return $this->responder->withPayload($result)->respond();
    }
}
