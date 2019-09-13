<?php

namespace App\Http\Actions\Ink;

use App\Models\Ink;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Ink\DeleteInkService;
use App\Http\Responders\Ink\DeleteInkResponder;

class DeleteInk extends Action
{
    /** @var \App\Http\Responders\Ink\DeleteInkResponder */
    private $responder;

    /**
    * Construct a new DeleteInk action.
    *
    * @param  \App\Http\Responders\Ink\DeleteInkResponder  $responder
    */
    public function __construct(DeleteInkResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Ink  $ink
     */
    public function __invoke(Ink $ink): RedirectResponse
    {
        $deleted = DeleteInkService::call($ink);

        return $this->responder->withPayload($deleted)->respond();
    }
}
