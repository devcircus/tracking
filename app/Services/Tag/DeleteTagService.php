<?php

namespace App\Services\Tag;

use App\Models\Tag;
use PerfectOblivion\Services\Traits\SelfCallingService;

class DeleteTagService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Tag  $tag
     */
    public function run(Tag $tag): Tag
    {
        $deleted = $tag->deleteTag();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => $deleted->package_number])
            ->log('tag deleted');

        return $deleted;
    }
}
