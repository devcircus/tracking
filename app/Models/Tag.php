<?php

namespace App\Models;

use App\Events\Tags\TagFinished;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $with = [
        'item',
    ];

    protected $casts = [
        'finished_at' => 'date:Y-m-d',
        'received_at' => 'date:Y-m-d',
    ];

    /**
     * A Tag belongs to an Item.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    /**
     * Store a new tag.
     *
     * @param  array  $data
     */
    public function storeTag(array $data): Tag
    {
        return $this->create([
            'item_id' => $data['item_id'],
            'package_number' => $data['package_number'],
            'received_at' => $data['received_at'],
            'finished_at' => $data['finished_at'],
        ]);
    }

    /**
     * Store multiple sequential tags.
     *
     * @param  array  $data
     */
    public function storeMultipleTags(array $data): array
    {
        $created = [];
        foreach (range($data['starting_package_number'], $data['ending_package_number']) as $packageNumber) {
            $created[] = $this->create([
                'item_id' => $data['item_id'],
                'package_number' => $packageNumber,
                'received_at' => $data['received_at'],
                'finished_at' => $data['finished_at'],
            ]);
        }

        return $created;
    }

    /**
     * Retrieve all tags.
     *
     * @param  bool  $withTrashed
     */
    public function retrieveAllTags(bool $withTrashed = false): Collection
    {
        return $this->orderByColumn('received_at', 'desc')->orderByColumn('package_number', 'desc')->withTrashed($withTrashed)->get();
    }

    /**
     * Delete Tag.
     */
    public function deleteTag(): Tag
    {
        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore Tag.
     */
    public function restoreTag(): Tag
    {
        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }

    /**
     * Finish Tag.
     */
    public function finishTag(): Tag
    {
        return tap($this, function ($instance) {
            $instance->finished_at = now();
            $instance->save();
            TagFinished::dispatch($instance);
        })->fresh();
    }

    /**
     * Finish Multiple Tags.
     *
     * @param  array  $data
     */
    public function finishMultipleTags(array $data): BaseCollection
    {
        return collect(range($data['starting_package_number'], $data['ending_package_number']))->map(function ($packageNumber) {
            $tag = $this->where('package_number', $packageNumber)->first();

            return $tag->finishTag();
        });
    }

    /**
     * Reactivate Tag.
     */
    public function reactivateTag(): Tag
    {
        return tap($this, function ($instance) {
            $instance->finished_at = null;

            return $instance->save();
        })->fresh();
    }
}
