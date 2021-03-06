<?php

namespace App\Http\Actions\Dashboard;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Dashboard\IndexResponder;
use App\Services\Report\IndexService as ReportIndexService;
use App\Services\Inventory\IndexService as InventoryIndexService;

class Index extends Action
{
    /** @var \App\Http\Responders\Dashboard\IndexResponder */
    private $responder;

    /**
     * Construct a new Dashboard Index action.
     *
     * @param  \App\Http\Responders\Dashboard\IndexResponder  $responder
     */
    public function __construct(IndexResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Show the application home page.
     */
    public function __invoke(): Response
    {
        return $this->responder->withPayload([
            'orders' => ReportIndexService::call(),
            'inventory' => InventoryIndexService::call(),
        ])->respond();
    }
}
