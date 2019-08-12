<?php

namespace App\Services\Tag\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreTagValidationService extends ValidationService
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'tag';

    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'package_number' => ['required', 'numeric', 'unique:tags,package_number'],
            'item_id' => ['required', 'numeric', 'exists:items,id'],
            'received_at' => ['required', 'date'],
            'finished_at' => ['nullable', 'date'],
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
            //
        ];
    }
}
