<?php

namespace App\Http\Actions\Tag;

use App\Http\DTO\TagData;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Tag\StoreTagService;
use Illuminate\Http\RedirectResponse;
use App\Http\Responders\Tag\StoreTagResponder;

class StoreTag extends Action
{
    /** @var \App\Http\Responders\Tag\StoreTagResponder */
    private $responder;

    /**
    * Construct a new StoreTag action.
    *
    * @param  \App\Http\Responders\Tag\StoreTagResponder  $responder
    */
    public function __construct(StoreTagResponder $responder)
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
        $data = TagData::fromRequest($request);
        StoreTagService::call($data);

        return $this->responder->respond();
    }
}
