<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Printer extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $with = ['ink', 'colors'];

    /** @var array */
    protected $appends = ['has_neon', 'has_standard'];

    /**
     * A Printer belongs to an Ink.
     */
    public function ink(): BelongsTo
    {
        return $this->belongsTo(Ink::class);
    }

    /**
     * A Printer belongs to many colors.
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class)->withPivot(['cyan', 'magenta', 'yellow', 'black', 'approved']);
    }

    /**
     * Get the has_neon attribute for this Printer.
     */
    public function getHasNeonAttribute(): bool
    {
        return $this->hasNeon();
    }

    /**
     * Get the has_standard attribute for this Printer.
     */
    public function getHasStandardAttribute(): bool
    {
        return $this->hasStandard();
    }

    /**
     * Does this Printer use neon colors?
     */
    public function hasNeon(): bool
    {
        return 'neon' === $this->ink->type;
    }

    /**
     * Does this Printer use standard colors?
     */
    public function hasStandard(): bool
    {
        return 'standard' === $this->ink->type;
    }

    /**
     * Get the specified colors for the Printer.
     */
    public function getColors(): Collection
    {
        return $this->colors()->get();
    }

    /**
     * Add a new Printer.
     *
     * @param  array  $data
     */
    public function addPrinter(array $data): Printer
    {
        return $this->create($data);
    }

    /**
     * Update a Printer.
     *
     * @param  array  $data
     */
    public function updatePrinter(array $data): Printer
    {
        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        })->fresh();
    }

    /**
     * Delete a Printer.
     */
    public function deletePrinter(): Printer
    {
        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted Printer.
     */
    public function restorePrinter(): Printer
    {
        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }
}
