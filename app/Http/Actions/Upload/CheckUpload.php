<?php

namespace App\Http\Actions\Upload;

use Illuminate\Http\JsonResponse;
use PerfectOblivion\Actions\Action;
use App\Services\Upload\CheckUploadService;
use App\Http\Responders\Upload\CheckUploadResponder;

class CheckUpload extends Action
{
    /** @var \App\Http\Responders\Upload\CheckUploadResponder */
    private $responder;

    /**
     * Construct a new CheckUpload action.
     *
     * @param  \App\Http\Responders\Upload\CheckUploadResponder  $responder
     */
    public function __construct(CheckUploadResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): JsonResponse
    {
        return $this->responder->withPayload(CheckUploadService::call());
    }
}
