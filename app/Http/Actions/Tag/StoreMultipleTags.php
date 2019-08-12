<?php

namespace App\Http\Actions\Tag;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Tag\StoreMultipleTagsService;
use App\Http\Responders\Tag\StoreMultipleTagsResponder;

class StoreMultipleTags extends Action
{
    /** @var \App\Http\Responders\Tag\StoreMultipleTagsResponder */
    private $responder;

    /**
    * Construct a new StoreMultipleTags action.
    *
    * @param  \App\Http\Responders\Tag\StoreMultipleTagsResponder  $responder
    */
    public function __construct(StoreMultipleTagsResponder $responder)
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
        $data = $request->only(['starting_package_number', 'ending_package_number', 'item_id', 'finished_at', 'received_at']);
        StoreMultipleTagsService::call($data);

        return $this->responder->respond();
    }
}
