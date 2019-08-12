<?php

namespace App\Http\Actions\Tag;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Tag\StoreTagService;
use App\Http\Responders\Tag\StoreTagResponder;
use App\Http\DTO\TagData;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = TagData::fromRequest($request);
        StoreTagService::call($data);

        return $this->responder->respond();
    }
}
