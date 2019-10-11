<?php

namespace App\Services\Upload;

use App\Models\Upload;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckUploadService
{
    use SelfCallingService;

    /** @var \App\Models\Upload */
    private $uploads;

    /**
     * Construct a new CheckUploadService.
     */
    public function __construct(Upload $uploads)
    {
        $this->uploads = $uploads;
    }

    /**
     * Handle the call to the service.
     */
    public function run(): bool
    {
        return $this->uploads->latestUploadInProgress();
    }
}
