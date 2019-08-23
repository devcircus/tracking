<?php

namespace App\Services\Tag;

use App\Models\Tag;
use Illuminate\Support\Collection;
use App\Services\Tag\FinishTagService;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Tag\Validation\FinishMultipleTagsValidationService;

class FinishMultipleTagsService
{
    use SelfCallingService;

    /** @var \App\Services\Tag\Validation\FinishMultipleTagsValidationService */
    private $validator;

    /** @var \App\Models\Tag */
    private $tags;

    /**
     * Construct a new FinishMultipleTagsService.
     *
     * @param  \App\Services\Tag\Validation\FinishMultipleTagsValidationService  $validator
     * @param  \App\Models\Tag  $tags
     */
    public function __construct(FinishMultipleTagsValidationService $validator, Tag $tags)
    {
        $this->validator = $validator;
        $this->tags = $tags;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $data
     */
    public function run(array $data): Collection
    {
        $this->validator->validate($data);

        return collect(range($data['starting_package_number'], $data['ending_package_number']))->map(function ($packageNumber) {
            $tag = $this->tags->where('package_number', $packageNumber)->first();

            return FinishTagService::call($tag);
        });
    }
}
