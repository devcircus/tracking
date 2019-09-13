<?php

namespace App\Http\Actions\Printer;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Printer\DeletePrinterService;
use App\Http\Responders\Printer\DeletePrinterResponder;
use App\Models\Printer;
use Illuminate\Http\RedirectResponse;

class DeletePrinter extends Action
{
    /** @var \App\Http\Responders\Printer\DeletePrinterResponder */
    private $responder;

    /**
    * Construct a new DeletePrinter action.
    *
    * @param  \App\Http\Responders\Printer\DeletePrinterResponder  $responder
    */
    public function __construct(DeletePrinterResponder $responder)
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
        $deleted = DeletePrinterService::call($printer);

        return $this->responder->withPayload($deleted)->respond();
    }
}
