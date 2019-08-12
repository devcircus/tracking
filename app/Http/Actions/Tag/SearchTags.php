<?php

namespace App\Http\Actions\Tag;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Tag\SearchTagsResponder;

class SearchTags extends Action
{
    /** @var \App\Http\Responders\Tag\SearchTagsResponder */
    private $responder;

    /**
     * Construct a new SearchTags action.
     *
     * @param  \App\Http\Responders\Tag\SearchTagsResponder  $responder
     */
    public function __construct(SearchTagsResponder $responder)
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
    }
}
