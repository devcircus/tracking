<?php

namespace App\Http\Actions\Printer;

use Inertia\Response;
use App\Models\Printer;
use PerfectOblivion\Actions\Action;
use App\Services\Materials\ListInksService;
use App\Http\Responders\Printer\ShowPrinterResponder;

class ShowPrinter extends Action
{
    /** @var \App\Http\Responders\Printer\ShowPrinterResponder */
    private $responder;

    /**
     * Construct a new ShowPrinter action.
     *
     * @param  \App\Http\Responders\Printer\ShowPrinterResponder  $responder
     */
    public function __construct(ShowPrinterResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Printer  $printer
     */
    public function __invoke(Printer $printer): Response
    {
        $inks = ListInksService::call();

        return $this->responder->withPayload([
            'printerData' => $printer,
            'inks' => $inks,
        ])->respond();
    }
}
