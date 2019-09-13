<?php

namespace App\Http\Actions\Printer;

use App\Models\Printer;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Printer\UpdatePrinterService;
use App\Http\Responders\Printer\UpdatePrinterResponder;

class UpdatePrinter extends Action
{
    /** @var \App\Http\Responders\Printer\UpdatePrinterResponder */
    private $responder;

    /**
     * Construct a new UpdatePrinter action.
     *
     * @param  \App\Http\Responders\Printer\UpdatePrinterResponder  $responder
     */
    public function __construct(UpdatePrinterResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request, Printer $printer)
    {
        $updated = UpdatePrinterService::call($printer, $request->only([
            'name', 'model', 'manufacturer', 'ink_id',
        ]));

        return $this->responder->withPayload($updated)->respond();
    }
}
