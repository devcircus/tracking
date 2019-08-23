<?php

namespace App\Services\Activity;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListActivitiesService
{
    use SelfCallingService;

    /** @var \Spatie\Activitylog\Models\Activity */
    private $activities;

    /**
     * Construct a new ListActivitiesService.
     *
     * @param  \Spatie\Activitylog\Models\Activity  $activities
     */
    public function __construct(Activity $activities)
    {
        $this->activities = $activities;
    }

    /**
     * Handle the call to the service.
     */
    public function run(): Collection
    {
        return $this->activities->with(['causer'])->latest()->get();
    }
}
