<?php

namespace App\Services\Tag;

use App\Models\Tag;
use App\Http\DTO\TagData;
use Illuminate\Support\Collection;
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
     */
    public function run(array $data): Collection
    {
        $this->validator->validate($data);

        return Collection::range($data['starting_package_number'], $data['ending_package_number'])->map(function ($packageNumber) use ($data) {
            return StoreTagService::call(TagData::fromArray([
                'item_id' => $data['item_id'],
                'package_number' => $packageNumber,
                'received_at' => $data['received_at'],
                'finished_at' => $data['finished_at'],
            ]));
        });
    }
}
