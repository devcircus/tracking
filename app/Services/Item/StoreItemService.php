<?php

namespace App\Services\Item;

use App\Models\Item;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Item\Validation\StoreItemValidationService;
use App\Http\DTO\ItemData;

class StoreItemService
{
    use SelfCallingService;

    /** @var \App\Services\Item\Validation\StoreItemValidationService */
    private $validator;

    /** @var \App\Models\Item */
    private $items;

    /**
     * Construct a new StoreItemService.
     *
     * @param  \App\Services\Item\Validation\StoreItemValidationService  $validator
     * @param  \App\Models\Item  $items
     */
    public function __construct(StoreItemValidationService $validator, Item $items)
    {
        $this->validator = $validator;
        $this->items = $items;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Http\DTO\ItemData  $data
     *
     * @return \App\Models\Item
     */
    public function run(ItemData $data)
    {
        $this->validator->validate($data->toArray());

        return $this->items->createItem($data->only(['name', 'minimum']));
    }
}
