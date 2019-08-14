<?php

namespace App\Models;

use App\Events\ReportsCreated;

class Upload extends Model
{
    /** @var array */
    protected $casts = [
        'upload_complete' => 'boolean',
        'reports_created' => 'boolean',
    ];

    /**
     * Store a new upload.
     *
     * @param  string  $date
     */
    public function storeUpload(string $date): Upload
    {
        return $this->query()->create([
            'uploaded_at' => $date,
            'upload_complete' => true,
        ]);
    }

    /**
     * Set reports_created for an Upload.
     *
     * @param  string  $date
     */
    public function reportsReady(string $date): Upload
    {
        $upload = Upload::where('uploaded_at', $date)->first();

        $upload = tap($upload, function($instance) {
            $instance->reports_created = true;
            $instance->save();
        })->fresh();

        ReportsCreated::broadcast();

        return $upload;
    }

    /**
     * Check if there is an upload in progress.
     *
     * @param  string  $date
     */
    public function uploadInProgressForDate(string $date): bool
    {
        $upload = Upload::where('uploaded_at', $date)->first();

        if (! $upload) {
            return false;
        }

        return ! $upload->reports_created;
    }

    /**
     * Check if there is an upload in progress.
     */
    public function latestUploadInProgress(): bool
    {
        $date = Upload::latest()->first()->uploaded_at;

        return $this->uploadInProgressForDate($date);
    }
}
