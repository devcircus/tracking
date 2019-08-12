<?php

namespace App\Http\Actions\Tag;

use App\Models\Tag;
use PerfectOblivion\Actions\Action;
use App\Services\Tag\RestoreTagService;
use App\Http\Responders\Tag\RestoreTagResponder;

class RestoreTag extends Action
{
    /** @var \App\Http\Responders\Tag\RestoreTagResponder */
    private $responder;

    /**
    * Construct a new RestoreTag action.
    *
    * @param  \App\Http\Responders\Tag\RestoreTagResponder  $responder
    */
    public function __construct(RestoreTagResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Tag  $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Tag $tag)
    {
        RestoreTagService::call($tag);

        return $this->responder->respond();
    }
}
