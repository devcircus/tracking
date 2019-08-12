<?php

namespace App\Services\Upload\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreUploadValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'upload' => ['file', 'mimes:xlsx'],
        ];
    }
}
