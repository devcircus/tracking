<?php

namespace App\Services\Upload;

use App\Models\Upload;
use App\Events\ReportsCreated;
use App\Models\User;
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
     * @param  \App\Models\User  $user
     */
    public function run(string $date, User $user): void
    {
        $uploaded = $this->uploads->storeUpload($date);

        activity()
            ->causedBy($user)
            ->performedOn($uploaded)
            ->withProperties(['target' => $uploaded->uploaded_at])
            ->log('report uploaded');
    }
}
