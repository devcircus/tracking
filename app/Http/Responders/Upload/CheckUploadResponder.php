<?php

namespace App\Http\Responders\Upload;

use PerfectOblivion\Responder\Responder;

class CheckUploadResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond()
    {
        return response()->json([
            'uploading' => $this->payload,
        ], 200);
    }
}
