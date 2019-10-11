<?php

namespace App\Services\Item\Validation;

use App\Rules\ItemHasNoTagsRule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class DeleteInventoryItemValidationService extends ValidationService
{
    /** @var string */
    protected $errorBag = 'item';

    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'id' => [new ItemHasNoTagsRule],
        ];
    }
}
