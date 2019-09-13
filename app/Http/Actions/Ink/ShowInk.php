<?php

namespace App\Http\Actions\Ink;

use Inertia\Response;
use App\Models\Ink;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Ink\ShowInkResponder;

class ShowInk extends Action
{
    /** @var \App\Http\Responders\Ink\ShowInkResponder */
    private $responder;

    /**
    * Construct a new ShowInk action.
    *
    * @param  \App\Http\Responders\Ink\ShowInkResponder  $responder
    */
    public function __construct(ShowInkResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Ink  $ink
     */
    public function __invoke(Ink $ink): Response
    {
        return $this->responder->withPayload($ink)->respond();
    }
}
