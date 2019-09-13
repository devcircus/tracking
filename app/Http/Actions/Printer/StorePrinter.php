<?php

namespace App\Http\Actions\Printer;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Printer\StorePrinterService;
use App\Http\Responders\Printer\StorePrinterResponder;
use Illuminate\Http\RedirectResponse;

class StorePrinter extends Action
{
    /** @var \App\Http\Responders\Printer\StorePrinterResponder */
    private $responder;

    /**
    * Construct a new StorePrinter action.
    *
    * @param  \App\Http\Responders\Printer\StorePrinterResponder  $responder
    */
    public function __construct(StorePrinterResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $printer = StorePrinterService::call($request->only([
            'name', 'model','manufacturer', 'ink_id'
        ]));

        return $this->responder->withPayload($printer)->respond();
    }
}
