<?php

namespace App\Services\Tag\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreTagValidationService extends ValidationService
{
    /** @var string */
    protected $errorBag = 'tag';

    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'package_number' => ['required', 'numeric', 'unique:tags,package_number'],
            'item_id' => ['required', 'numeric', 'exists:items,id'],
            'received_at' => ['required', 'date'],
            'finished_at' => ['nullable', 'date'],
        ];
    }
}
