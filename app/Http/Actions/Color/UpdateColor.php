<?php

namespace App\Http\Actions\Color;

use App\Models\Color;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Color\UpdateColorService;
use App\Http\Responders\Color\UpdateColorResponder;

class UpdateColor extends Action
{
    /** @var \App\Http\Responders\Color\UpdateColorResponder */
    private $responder;

    /**
     * Construct a new UpdateColor action.
     *
     * @param  \App\Http\Responders\Color\UpdateColorResponder  $responder
     */
    public function __construct(UpdateColorResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     */
    public function __invoke(Request $request, Color $color): RedirectResponse
    {
        $updated = UpdateColorService::call($color, $request->only([
            'code', 'name', 'type'
        ]));

        return $this->responder->withPayload($updated)->respond();
    }
}
