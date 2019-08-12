<?php

namespace App\Http\Actions\Tag;

use App\Models\Tag;
use PerfectOblivion\Actions\Action;
use App\Services\Tag\FinishTagService;
use App\Http\Responders\Tag\FinishTagResponder;

class FinishTag extends Action
{
    /** @var \App\Http\Responders\Tag\FinishTagResponder */
    private $responder;

    /**
    * Construct a new FinishTag action.
    *
    * @param  \App\Http\Responders\Tag\FinishTagResponder  $responder
    */
    public function __construct(FinishTagResponder $responder)
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
        FinishTagService::call($tag);

        return $this->responder->respond();
    }
}
