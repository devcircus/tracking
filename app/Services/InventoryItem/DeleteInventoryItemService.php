<?php

namespace App\Services\Item;

use App\Models\InventoryItem;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Item\Validation\DeleteInventoryItemValidationService;

class DeleteInventoryItemService
{
    use SelfCallingService;

    /** @var \App\Services\Item\Validation\DeleteInventoryItemValidationService */
    private $validator;

    /**
     * Construct a new DeleteInventoryItemService.
     *
     * @param  \App\Services\Item\Validation\DeleteInventoryItemValidationService  $validator
     */
    public function __construct(DeleteInventoryItemValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\InventoryItem  $item
     */
    public function run(InventoryItem $item): InventoryItem
    {
        $this->validator->validate(['id' => $item->id]);

        $deleted = $item->DeleteInventoryItem();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => $deleted->name])
            ->log('item deleted');

        return $deleted;
    }
}
