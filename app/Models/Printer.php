<?php

namespace App\Models;

use App\Services\Cache\CacheForgetService;
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
        return $this->colors()->orderBy('code', 'asc')->get();
    }

    /**
     * Add a new Printer.
     *
     * @param  array  $data
     */
    public function addPrinter(array $data): Printer
    {
        CacheForgetService::call('printers');

        $printer = $this->create([
            'name' => $data['name'],
            'model' => $data['model'],
            'manufacturer' => $data['manufacturer'],
            'ink_id' => $data['ink_id'],
        ]);

        if ($existing_id = $data['copy_printer_id']) {
            $existingPrinter = $this->find($existing_id);
            foreach ($existingPrinter->colors as $color) {
                $printer->colors()->attach($color->id, [
                    'approved' => $color->pivot->approved,
                    'cyan' => $color->pivot->cyan,
                    'magenta' => $color->pivot->magenta,
                    'yellow' => $color->pivot->yellow,
                    'black' => $color->pivot->black,
                ]);
            }
            $printer->save();
        }

        return $printer;
    }

    /**
     * Update a Printer.
     *
     * @param  array  $data
     */
    public function updatePrinter(array $data): Printer
    {
        CacheForgetService::call('printers');

        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        })->fresh();
    }

    /**
     * Delete a Printer.
     */
    public function deletePrinter(): Printer
    {
        CacheForgetService::call('printers');

        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted Printer.
     */
    public function restorePrinter(): Printer
    {
        CacheForgetService::call('printers');

        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }

    /**
     * Set the values for the given color for the printer.
     *
     * @param  \App\Models\Color  $color
     * @param  array  $data
     */
    public function setPrinterColor(Color $color, array $data): void
    {
        CacheForgetService::call('printer-colors', $this->name);

        if ($this->colors->contains($color)) {
            $this->colors()->updateExistingPivot($color->id, $data);
        } else {
            $this->colors()->attach($color->id, $data);
        }
    }
}
