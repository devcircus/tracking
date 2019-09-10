<?php

namespace App\Http\Actions\Artwork;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Artwork\BatchArtCompleteService;
use App\Http\Responders\Artwork\BatchArtCompleteResponder;

class BatchArtComplete extends Action
{
    /** @var \App\Http\Responders\Artwork\BatchArtCompleteResponder */
    private $responder;

    /**
    * Construct a new BatchArtComplete action.
    *
    * @param  \App\Http\Responders\Artwork\BatchArtCompleteResponder  $responder
    */
    public function __construct(BatchArtCompleteResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $result = BatchArtCompleteService::call($request->artwork);

        return $this->responder->withPayload($result)->respond();
    }
}
