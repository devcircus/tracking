<?php

namespace App\Http\Actions\Ink;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Ink\CreateInkResponder;

class CreateInk extends Action
{
    /** @var \App\Http\Responders\Ink\CreateInkResponder */
    private $responder;

    /**
    * Construct a new CreateInk action.
    *
    * @param  \App\Http\Responders\Ink\CreateInkResponder  $responder
    */
    public function __construct(CreateInkResponder $responder)
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
