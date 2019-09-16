<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ink extends Model
{
    use SoftDeletes;

    /**
     * An Ink belongs to many Colors.
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class)->withPivot(['cyan', 'magenta', 'yellow', 'black', 'approved']);
    }

    /**
     * An Ink has many Printers.
     */
    public function printers(): HasMany
    {
        return $this->hasMany(Printer::class);
    }

    /**
     * Add a new Ink.
     *
     * @param  array  $data
     */
    public function addInk(array $data): Ink
    {
        return $this->create($data);
    }

    /**
     * Update a Ink.
     *
     * @param  array  $data
     */
    public function updateInk(array $data): Ink
    {
        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        })->fresh();
    }

    /**
     * Delete a Ink.
     */
    public function deleteInk(): Ink
    {
        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted Ink.
     */
    public function restoreInk(): Ink
    {
        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }
}
