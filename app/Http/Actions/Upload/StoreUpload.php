<?php

namespace App\Http\Actions\Upload;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Upload\StoreUploadService;
use App\Http\Responders\Upload\StoreUploadResponder;

class StoreUpload extends Action
{
    /** @var \App\Http\Responders\Upload\StoreUploadResponder */
    private $responder;

    /**
     * Construct a new StoreUpload action.
     *
     * @param  \App\Http\Responders\Upload\StoreUploadResponder  $responder
     */
    public function __construct(StoreUploadResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request)
    {
        StoreUploadService::call($request->file('upload'));

        return response()->json(['message' => 'ok what now'], 200);
    }
}
