<?php

namespace App\Services\Item\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreInventoryItemValidationService extends ValidationService
{
    /** @var string */
    protected $errorBag = 'item';

    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'unique:items,name'],
            'minimum' => ['required', 'numeric'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'name' => ['trim', 'strip_tags'],
        ];
    }
}
