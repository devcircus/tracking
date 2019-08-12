<?php

namespace App\Http\Actions\Tag;

use App\Models\Tag;
use PerfectOblivion\Actions\Action;
use App\Services\Tag\ReactivateTagService;
use App\Http\Responders\Tag\ReactivateTagResponder;

class ReactivateTag extends Action
{
    /** @var \App\Http\Responders\Tag\ReactivateTagResponder */
    private $responder;

    /**
    * Construct a new ReactivateTag action.
    *
    * @param  \App\Http\Responders\Tag\ReactivateTagResponder  $responder
    */
    public function __construct(ReactivateTagResponder $responder)
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
        ReactivateTagService::call($tag);

        return $this->responder->respond();
    }
}
