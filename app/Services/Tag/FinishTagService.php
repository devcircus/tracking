<?php

namespace App\Services\Tag;

use App\Models\Tag;
use PerfectOblivion\Services\Traits\SelfCallingService;

class FinishTagService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Tag  $tag
     */
    public function run(Tag $tag): Tag
    {
        $finished = $tag->finishTag();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($finished)
            ->withProperties(['target' => $finished->package_number])
            ->log('tag finished');

        return $tag;
    }
}
