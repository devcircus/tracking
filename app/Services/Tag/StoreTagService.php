<?php

namespace App\Services\Tag;

use App\Models\Tag;
use App\Http\DTO\TagData;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Tag\Validation\StoreTagValidationService;

class StoreTagService
{
    use SelfCallingService;

    /** @var \App\Services\Tag\Validation\StoreTagValidationService */
    private $validator;

    /** @var \App\Models\Tag */
    private $tags;

    /**
     * Construct a new StoreTagService.
     *
     * @param  \App\Services\Tag\Validation\StoreTagValidationService  $validator
     * @param  \App\Models\Tag  $tags
     */
    public function __construct(StoreTagValidationService $validator, Tag $tags)
    {
        $this->validator = $validator;
        $this->tags = $tags;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Http\DTO\TagData  $data
     *
     * @return mixed
     */
    public function run(TagData $data)
    {
        $this->validator->validate($data->toArray());

        return $this->tags->storeTag($data->only(['item_id', 'package_number', 'received_at', 'finished_at']));
    }
}
