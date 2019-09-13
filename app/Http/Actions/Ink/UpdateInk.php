<?php

namespace App\Http\Actions\Ink;

use App\Models\Ink;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Ink\UpdateInkService;
use App\Http\Responders\Ink\UpdateInkResponder;

class UpdateInk extends Action
{
    /** @var \App\Http\Responders\Ink\UpdateInkResponder */
    private $responder;

    /**
     * Construct a new UpdateInk action.
     *
     * @param  \App\Http\Responders\Ink\UpdateInkResponder  $responder
     */
    public function __construct(UpdateInkResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ink  $ink
     */
    public function __invoke(Request $request, Ink $ink): RedirectResponse
    {
        $updated = UpdateInkService::call($ink, $request->only([
            'version', 'type', 'manufacturer'
        ]));

        return $this->responder->withPayload($updated)->respond();
    }
}
