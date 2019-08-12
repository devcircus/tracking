<?php

namespace App\Services\Tag;

use App\Models\Tag;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Tag\Validation\StoreMultipleTagsValidationService;

class StoreMultipleTagsService
{
    use SelfCallingService;

    /** @var  \App\Services\Tag\Validation\StoreMultipleTagsValidationService */
    private $validator;

    /** @var \App\Models\Tag */
    private $tags;

    /**
     * Construct a new StoreMultipleTagsService.
     *
     * @param  \App\Services\Tag\Validation\StoreMultipleTagsValidationService  $validator
     * @param  \App\Models\Tag  $tags
     */
    public function __construct(StoreMultipleTagsValidationService $validator, Tag $tags)
    {
        $this->validator = $validator;
        $this->tags = $tags;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function run(array $data)
    {
        $this->validator->validate($data);

        return $this->tags->storeMultipleTags($data);
    }
}
