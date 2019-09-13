<?php

namespace App\Http\Actions\Color;

use App\Models\Color;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Color\DeleteColorService;
use App\Http\Responders\Color\DeleteColorResponder;

class DeleteColor extends Action
{
    /** @var \App\Http\Responders\Color\DeleteColorResponder */
    private $responder;

    /**
    * Construct a new DeleteColor action.
    *
    * @param  \App\Http\Responders\Color\DeleteColorResponder  $responder
    */
    public function __construct(DeleteColorResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Color  $color
     */
    public function __invoke(Color $color): RedirectResponse
    {
        $deleted = DeleteColorService::call($color);

        return $this->responder->withPayload($deleted)->respond();
    }
}
