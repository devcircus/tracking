<?php

namespace App\Services\Item\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreInventoryItemValidationService extends ValidationService
{
    /** @var string */
    protected $errorBag = 'item';

    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'unique:items,name'],
            'minimum' => ['required', 'numeric'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'name' => ['trim', 'strip_tags'],
        ];
    }
}