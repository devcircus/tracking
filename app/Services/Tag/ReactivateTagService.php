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
        $reactivated = $tag->reactivateTag();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($reactivated)
            ->withProperties(['target' => $reactivated->package_number])
            ->log('tag reactivated');

        return $reactivated;
    }
}
