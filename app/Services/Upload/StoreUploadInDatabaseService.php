<?php

namespace App\Services\Upload;

use App\Models\Upload;
use App\Events\ReportsCreated;
use PerfectOblivion\Services\Traits\SelfCallingService;

class StoreUploadInDatabaseService
{
    use SelfCallingService;

    /** @var \App\Models\Upload */
    private $uploads;

    /**
     * Construct a new StoreUploadInDatabaseService.
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
    public function run(string $date): void
    {
        $this->uploads->storeUpload($date);
    }
}
