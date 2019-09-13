<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use SoftDeletes;

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
        return $this->create($data);
    }

    /**
     * Update a Color.
     *
     * @param  array  $data
     */
    public function updateColor(array $data): Color
    {
        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        })->fresh();
    }

    /**
     * Delete a Color.
     */
    public function deleteColor(): Color
    {
        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted Color.
     */
    public function restoreColor(): Color
    {
        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }
}
