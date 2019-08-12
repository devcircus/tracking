<?php

namespace App\Http\Actions\Info;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Http\DTO\InfoDataCollection;
use App\Services\Info\UpdateInfoService;
use App\Http\Responders\Info\UpdateInfoResponder;

class UpdateInfo extends Action
{
    /** @var \App\Http\Responders\Info\UpdateInfoResponder */
    private $responder;

    /**
    * Construct a new UpdateInfo action.
    *
    * @param  \App\Http\Responders\Info\UpdateInfoResponder  $responder
    */
    public function __construct(UpdateInfoResponder $responder)
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
        $result = UpdateInfoService::call($request->info);

        return $this->responder->withPayload($result)->respond();
    }
}
