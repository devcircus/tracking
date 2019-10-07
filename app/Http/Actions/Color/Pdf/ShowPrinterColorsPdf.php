<?php

namespace App\Http\Actions\Color\Pdf;

use App\Models\Printer;
use Illuminate\Http\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Color\ShowPrinterColorsService;
use App\Http\Responders\Color\Pdf\ShowPrinterColorsPdfResponder;

class ShowPrinterColorsPdf extends Action
{
    /** @var \App\Http\Responders\Color\Pdf\ShowPrinterColorsPdfResponder */
    private $responder;

    /**
     * Construct a new ShowPrinterColorsPdf action.
     *
     * @param  \App\Http\Responders\Color\Pdf\ShowPrinterColorsPdfResponder  $responder
     */
    public function __construct(ShowPrinterColorsPdfResponder $responder)
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
