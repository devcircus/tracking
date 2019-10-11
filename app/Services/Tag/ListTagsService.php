<?php

namespace App\Services\Tag;

use App\Models\Tag;
use Illuminate\Support\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListTagsService
{
    use SelfCallingService;

    /** @var \App\Models\Tag */
    private $tags;

    /**
     * Construct a new ListTagsService.
     *
     * @param  \App\Models\Tag  $tags
     */
    public function __construct(Tag $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Handle the call to the service.
     */
    public function run(): Collection
    {
        return $this->tags->retrieveAllTags($withTrashed = true);
    }
}
