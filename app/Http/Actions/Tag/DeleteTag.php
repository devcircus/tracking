<?php

namespace App\Http\Actions\Tag;

use App\Models\Tag;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Tag\DeleteTagService;
use App\Http\Responders\Tag\DeleteTagResponder;

class DeleteTag extends Action
{
    /** @var \App\Http\Responders\Tag\DeleteTagResponder */
    private $responder;

    /**
    * Construct a new DeleteTag action.
    *
    * @param  \App\Http\Responders\Tag\DeleteTagResponder  $responder
    */
    public function __construct(DeleteTagResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Tag  $tag
     */
    public function __invoke(Tag $tag): RedirectResponse
    {
        DeleteTagService::call($tag);

        return $this->responder->respond();
    }
}
