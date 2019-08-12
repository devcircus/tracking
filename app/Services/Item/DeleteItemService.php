<?php

namespace App\Services\Item;

use App\Models\Item;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Item\Validation\DeleteItemValidationService;

class DeleteItemService
{
    use SelfCallingService;

    /** @var \App\Services\Item\Validation\DeleteItemValidationService */
    private $validator;

    /**
     * Construct a new DeleteItemService.
     *
     * @param  \App\Services\Item\Validation\DeleteItemValidationService  $validator
     */
    public function __construct(DeleteItemValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Item  $item
     */
    public function run(Item $item): Item
    {
        $this->validator->validate(['id' => $item->id]);

        return $item->deleteItem();
    }
}
