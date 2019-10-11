<?php

namespace App\Services\Tag\Validation;

use App\Rules\UniqueInRangeRule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreMultipleTagsValidationService extends ValidationService
{
    /** @var string */
    protected $errorBag = 'tags';

    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'starting_package_number' => ['required', 'numeric', 'lt:ending_package_number', new UniqueInRangeRule],
            'ending_package_number' => ['required', 'numeric', 'gt:starting_package_number'],
            'item_id' => ['required', 'numeric', 'exists:items,id'],
            'received_at' => ['required', 'date'],
            'finished_at' => ['nullable', 'date'],
        ];
    }
}
