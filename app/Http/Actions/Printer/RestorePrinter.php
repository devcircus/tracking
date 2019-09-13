<?php

namespace App\Http\Actions\Printer;

use App\Models\Printer;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Printer\RestorePrinterService;
use App\Http\Responders\Printer\RestorePrinterResponder;

class RestorePrinter extends Action
{
    /** @var \App\Http\Responders\Printer\RestorePrinterResponder */
    private $responder;

    /**
    * Construct a new RestorePrinter action.
    *
    * @param  \App\Http\Responders\Printer\RestorePrinterResponder  $responder
    */
    public function __construct(RestorePrinterResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Printer  $printer
     */
    public function __invoke(Printer $printer): RedirectResponse
    {
        $restored = RestorePrinterService::call($printer);

        return $this->responder->withPayload($restored)->respond();
    }
}
