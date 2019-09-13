<?php

namespace App\Http\Actions\Color;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Color\CreateColorResponder;

class CreateColor extends Action
{
    /** @var \App\Http\Responders\Color\CreateColorResponder */
    private $responder;

    /**
    * Construct a new CreateColor action.
    *
    * @param  \App\Http\Responders\Color\CreateColorResponder  $responder
    */
    public function __construct(CreateColorResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        return $this->responder->respond();
    }
}
