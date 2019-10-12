<?php

namespace App\Services\Report;

use App\Models\Upload;
use PerfectOblivion\Services\Traits\SelfCallingService;

class MarkReportsReadyService
{
    use SelfCallingService;

    /** @var \App\Models\Upload */
    private $uploads;

    /**
     * Construct a new MarkReportsReadyService.
     *
     * @param  \App\Models\Upload  $uploads
     */
    public function __construct(Upload $uploads)
    {
        $this->uploads = $uploads;
    }

    /**
     * Handle the call to the service.
     *
     * @param  string  $date
     */
    public function run(string $date): Upload
    {
        return $this->uploads->reportsReady($date);
    }
}
