<?php

namespace App\Http\Actions\Report;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Report\IndexService;
use App\Http\Responders\Report\IndexResponder;

class Index extends Action
{
    /** @var \App\Http\Responders\Report\IndexResponder */
    private $responder;

    /**
     * Construct a new Report Index action.
     *
     * @param  \App\Http\Responders\Report\IndexResponder  $responder
     */
    public function __construct(IndexResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        $data = IndexService::call();

        return $this->responder->withPayload($data)->respond();
    }
}
