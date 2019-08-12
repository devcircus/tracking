<?php

namespace App\Services\Tag;

use App\Models\Tag;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ReactivateTagService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Tag  $tag
     */
    public function run(Tag $tag): Tag
    {
        return $tag->reactivateTag();
    }
}
