<?php

namespace App\Http\Actions\Color;

use App\Models\Color;
use App\Models\Printer;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Color\SetColorService;
use App\Http\Responders\Color\SetColorResponder;

class SetColor extends Action
{
    /** @var \App\Http\Responders\Color\SetColorResponder */
    private $responder;

    /**
    * Construct a new SetColor action.
    *
    * @param  \App\Http\Responders\Color\SetColorResponder  $responder
    */
    public function __construct(SetColorResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @param  \App\Models\Printer  $printer
     */
    public function __invoke(Request $request, Color $color, Printer $printer): RedirectResponse
    {
        SetColorService::call($color, $printer, $request->only(['approved', 'cyan', 'magenta', 'yellow', 'black']));

        return $this->responder->respond();
    }
}
