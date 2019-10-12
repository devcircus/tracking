<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use SoftDeletes;
    use LogsActivity;

    /** @var string */
    protected $table = 'items';

    /** @var array */
    protected static $recordEvents = [];

    /**
     * Get the in_stock attribute for an Item.
     */
    public function getInStockAttribute(): int
    {
        return $this->tags()->whereNull('finished_at')->count();
    }

    /**
     * An Item has many tags.
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'item_id');
    }

    /**
     * An Item has many recently finished tags.
     */
    public function recentlyFinishedTags(): HasMany
    {
        return $this->hasMany(Tag::class, 'item_id')->where('finished_at', '>=', now()->subDays(30));
    }

    /**
     * An Item has many recently received tags.
     */
    public function recentlyReceivedTags(): HasMany
    {
        return $this->hasMany(Tag::class, 'item_id')->where('received_at', '>=', now()->subDays(30));
    }

    /**
     * An Item has many active tags.
     */
    public function activeTags(): HasMany
    {
        return $this->hasMany(Tag::class, 'item_id')->whereNull('finished_at');
    }

    /**
     * Does an Item have tags associated with it?
     */
    public function hasTags(): bool
    {
        return $this->tags->count() > 0;
    }

    /**
     * Get the items that have reached minimum inventory.
     */
    public function needsReordering(): array
    {
        $items = $this->withCount('activeTags')->get();

        return $items->filter(function($item) {
            return $item->minimum !== 0 && $item->minimum >= $item->active_tags_count;
        })->values()->toArray();
    }

    /**
     * Include the in-stock tag count with the model.
     */
    public function withInStockCount(): InventoryItem
    {
        return $this->loadCount('activeTags');
    }

    /**
     * Include the recently finished and activated tags with the model.
     */
    public function withRecentTags(): InventoryItem
    {
        return $this->load(['recentlyFinishedTags', 'recentlyReceivedTags']);
    }

    /**
     * Include the active tags with the model.
     */
    public function withActiveTags(): InventoryItem
    {
        return $this->load(['activeTags']);
    }

    /**
     * Has the inventory for this item reached the minimum level?
     */
    public function reachedMinimumInventory(): bool
    {
        return $this->withInStockCount()->active_tags_count <= $this->minimum;
    }

    /**
     * Retrieve all items.
     *
     * @param  bool  $withTrashed
     */
    public function retrieveAllItems(bool $withTrashed = false): Collection
    {
        return $this->withTrashed($withTrashed)->withCount(['tags' => function (Builder $query) {
            $query->whereNull('finished_at');
        }])->get();
    }

    /**
     * Create Item.
     *
     * @param  array  $data
     */
    public function createItem(array $data): InventoryItem
    {
        return $this->create($data);
    }

    /**
     * Delete Item.
     */
    public function deleteInventoryItem(): InventoryItem
    {
        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore Item.
     */
    public function restoreInventoryItem(): InventoryItem
    {
        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }

    /**
     * Update Item.
     *
     * @param  array  $data
     */
    public function updateInventoryItem(array $data): InventoryItem
    {
        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        });
    }
}
