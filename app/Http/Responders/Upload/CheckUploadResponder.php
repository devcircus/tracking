<?php

namespace App\Http\Responders\Upload;

use Illuminate\Http\JsonResponse;
use PerfectOblivion\Responder\Responder;

class CheckUploadResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): JsonResponse
    {
        return response()->json([
            'uploading' => $this->payload,
        ], 200);
    }
}
