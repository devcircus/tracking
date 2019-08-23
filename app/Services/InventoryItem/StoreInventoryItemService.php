<?php

namespace App\Services\Item;

use App\Models\InventoryItem;
use App\Http\DTO\InventoryItemData;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Item\Validation\StoreInventoryItemValidationService;

class StoreInventoryItemService
{
    use SelfCallingService;

    /** @var \App\Services\Item\Validation\StoreInventoryItemValidationService */
    private $validator;

    /** @var \App\Models\InventoryItem */
    private $items;

    /**
     * Construct a new StoreInventoryItemService.
     *
     * @param  \App\Services\Item\Validation\StoreInventoryItemValidationService  $validator
     * @param  \App\Models\InventoryItem  $items
     */
    public function __construct(StoreInventoryItemValidationService $validator, InventoryItem $items)
    {
        $this->validator = $validator;
        $this->items = $items;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Http\DTO\InventoryItemData  $data
     */
    public function run(InventoryItemData $data): InventoryItem
    {
        $this->validator->validate($data->toArray());

        $created = $this->items->createItem($data->only(['name', 'minimum']));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($created)
            ->withProperties(['target' => $created->name])
            ->log('item created');

        return $created;
    }
}
