<?php

namespace App\Http\Actions\Activity;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Activity\ListActivitiesService;
use App\Http\Responders\Activity\ListActivitiesResponder;

class ListActivities extends Action
{
    /** @var \App\Http\Responders\Activity\ListActivitiesResponder */
    private $responder;

    /**
    * Construct a new ListActivities action.
    *
    * @param  \App\Http\Responders\Activity\ListActivitiesResponder  $responder
    */
    public function __construct(ListActivitiesResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        $activities = ListActivitiesService::call();

        return $this->responder->withPayload($activities)->respond();
    }
}
