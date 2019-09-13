<?php

namespace App\Http\Actions\Color;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Color\ShowColorResponder;
use App\Models\Color;
use Inertia\Response;

class ShowColor extends Action
{
    /** @var \App\Http\Responders\Color\ShowColorResponder */
    private $responder;

    /**
    * Construct a new ShowColor action.
    *
    * @param  \App\Http\Responders\Color\ShowColorResponder  $responder
    */
    public function __construct(ShowColorResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Color  $color
     */
    public function __invoke(Color $color): Response
    {
        return $this->responder->withPayload($color->load(['printers']))->respond();
    }
}
