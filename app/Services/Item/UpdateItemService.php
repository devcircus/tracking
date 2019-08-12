<?php

namespace App\Services\Item;

use App\Models\Item;
use App\Http\DTO\ItemData;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Item\Validation\UpdateItemValidationService;

class UpdateItemService
{
    use SelfCallingService;

    /** @var \App\Services\Item\Validation\UpdateItemValidationService */
    private $validator;

    /**
     * Construct a new UpdateItemService.
     *
     * @param  \App\Services\Item\Validation\UpdateItemValidationService  $validator
     */
    public function __construct(UpdateItemValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Item  $item
     * @param  \App\Http\DTO\ItemData  $data
     *
     * @return \App\Models\Item
     */
    public function run(Item $item, ItemData $data)
    {
        $this->validator->validate($data->toArray());

        return $item->updateItem($data->only(['name', 'minimum']));
    }
}
