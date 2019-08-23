<?php

namespace App\Http\Responders\Activity;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ListActivitiesResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Activities/Index', [
            'activities' => $this->payload,
        ]);
    }
}
