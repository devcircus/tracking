<?php

namespace App\Models;

use App\Services\Cache\CacheForgetService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $casts = [
        'custom' => 'boolean',
    ];

    /**
     * A color belongs to many Inks.
     */
    public function inks(): BelongsToMany
    {
        return $this->belongsToMany(Ink::class)->withPivot(['cyan', 'magenta', 'yellow', 'black', 'approved']);
    }

    /**
     * A color belongs to many Printers.
     */
    public function printers(): BelongsToMany
    {
        return $this->belongsToMany(Printer::class)->withPivot(['cyan', 'magenta', 'yellow', 'black', 'approved']);
    }

    /**
     * Add a new Color.
     *
     * @param  array  $data
     */
    public function addColor(array $data): Color
    {
        CacheForgetService::call('colors');

        return $this->create($data);
    }

    /**
     * Update a Color.
     *
     * @param  array  $data
     */
    public function updateColor(array $data): Color
    {
        CacheForgetService::call('colors');

        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        })->fresh();
    }

    /**
     * Delete a Color.
     */
    public function deleteColor(): Color
    {
        CacheForgetService::call('colors');

        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted Color.
     */
    public function restoreColor(): Color
    {
        CacheForgetService::call('colors');

        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }
}
