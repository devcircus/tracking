<?php

namespace App\Http\Actions\Tag;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Tag\FinishMultipleTagsService;
use App\Http\Responders\Tag\FinishMultipleTagsResponder;

class FinishMultipleTags extends Action
{
    /** @var \App\Http\Responders\Tag\FinishMultipleTagsResponder */
    private $responder;

    /**
     * Construct a new FinishMultipleTags action.
     *
     * @param  \App\Http\Responders\Tag\FinishMultipleTagsResponder  $responder
     */
    public function __construct(FinishMultipleTagsResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): RedirectResponse
    {
        FinishMultipleTagsService::call($request->only(['starting_package_number', 'ending_package_number']));

        return $this->responder->respond();
    }
}
