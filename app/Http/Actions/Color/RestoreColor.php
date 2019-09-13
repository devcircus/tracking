<?php

namespace App\Http\Actions\Color;

use App\Models\Color;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Color\RestoreColorService;
use App\Http\Responders\Color\RestoreColorResponder;

class RestoreColor extends Action
{
    /** @var \App\Http\Responders\Color\RestoreColorResponder */
    private $responder;

    /**
    * Construct a new RestoreColor action.
    *
    * @param  \App\Http\Responders\Color\RestoreColorResponder  $responder
    */
    public function __construct(RestoreColorResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Color  $color
     */
    public function __invoke(Color $color): RedirectResponse
    {
        $restored = RestoreColorService::call($color);

        return $this->responder->withPayload($restored)->respond();
    }
}
