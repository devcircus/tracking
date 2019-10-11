<?php

namespace App\Services\Tag\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class FinishMultipleTagsValidationService extends ValidationService
{
    /** @var string */
    protected $errorBag = 'tags_finish';

    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'starting_package_number' => ['required', 'numeric', 'lt:ending_package_number'],
            'ending_package_number' => ['required', 'numeric', 'gt:starting_package_number'],
        ];
    }
}
