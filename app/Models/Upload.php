<?php

namespace App\Models;

use App\Events\ReportsCreated;
use Spatie\Activitylog\Traits\LogsActivity;

class Upload extends Model
{
    use LogsActivity;

    /** @var array */
    protected $casts = [
        'upload_complete' => 'boolean',
        'reports_created' => 'boolean',
    ];

    /** @var array */
    protected static $recordEvents = [];

    /**
     * Store a new upload.
     *
     * @param  string  $date
     */
    public function storeUpload(string $date): self
    {
        return $this->query()->create([
            'uploaded_at' => $date,
            'upload_complete' => true,
        ]);
    }

    /**
     * Note that the reports have been created for an Upload date.
     *
     * @param  string  $date
     */
    public function reportsReady(string $date): self
    {
        $upload = self::where('uploaded_at', $date)->first();

        $upload = tap($upload, function ($instance) {
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
        $upload = self::where('uploaded_at', $date)->first();

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
        if (! $latest = self::latest()->first()) {
            return false;
        }

        return $this->uploadInProgressForDate($latest->uploaded_at);
    }
}
