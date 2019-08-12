<?php

namespace App\Services\Order\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdateOrderServiceValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'info' => ['string', 'nullable'],
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
            'info' => ['trim', 'strip_tags'],
        ];
    }
}
