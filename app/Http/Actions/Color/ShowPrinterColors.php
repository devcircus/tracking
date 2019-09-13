<?php

namespace App\Http\Actions\Color;

use Inertia\Response;
use App\Models\Printer;
use PerfectOblivion\Actions\Action;
use App\Services\Color\ShowPrinterColorsService;
use App\Http\Responders\Color\ShowPrinterColorsResponder;

class ShowPrinterColors extends Action
{
    /** @var \App\Http\Responders\Color\ShowPrinterColorsResponder */
    private $responder;

    /**
    * Construct a new ShowPrinterColors action.
    *
    * @param  \App\Http\Responders\Color\ShowPrinterColorsResponder  $responder
    */
    public function __construct(ShowPrinterColorsResponder $responder)
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
        $colors = ShowPrinterColorsService::call($printer);

        return $this->responder->withPayload([
            'printer' => $printer,
            'colors' => $colors,
        ])->respond();
    }
}
