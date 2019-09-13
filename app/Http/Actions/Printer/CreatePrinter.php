<?php

namespace App\Http\Actions\Printer;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Materials\ListInksService;
use App\Http\Responders\Printer\CreatePrinterResponder;

class CreatePrinter extends Action
{
    /** @var \App\Http\Responders\Printer\CreatePrinterResponder */
    private $responder;

    /**
    * Construct a new CreatePrinter action.
    *
    * @param  \App\Http\Responders\Printer\CreatePrinterResponder  $responder
    */
    public function __construct(CreatePrinterResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        $inks = ListInksService::call();

        return $this->responder->withPayload([
            'inks' => $inks,
        ])->respond();
    }
}
