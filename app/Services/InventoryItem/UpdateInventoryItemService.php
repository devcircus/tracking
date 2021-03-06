<?php

namespace App\Services\Item;

use App\Models\InventoryItem;
use App\Http\DTO\InventoryItemData;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Item\Validation\UpdateInventoryItemValidationService;

class UpdateInventoryItemService
{
    use SelfCallingService;

    /** @var \App\Services\Item\Validation\UpdateInventoryItemValidationService */
    private $validator;

    /**
     * Construct a new UpdateInventoryItemService.
     *
     * @param  \App\Services\Item\Validation\UpdateInventoryItemValidationService  $validator
     */
    public function __construct(UpdateInventoryItemValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\InventoryItem  $item
     * @param  \App\Http\DTO\InventoryItemData  $data
     */
    public function run(InventoryItem $item, InventoryItemData $data): InventoryItem
    {
        $this->validator->validate($data->toArray());

        $updated = $item->UpdateInventoryItem($data->only(['name', 'minimum']));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($updated)
            ->withProperties(['target' => $updated->name])
            ->log('item updated');

        return $updated;
    }
}
