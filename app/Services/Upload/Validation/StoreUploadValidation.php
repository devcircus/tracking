<?php

namespace App\Services\Upload\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreUploadValidation extends ValidationService
{
    /** @var string */
    protected $errorBag = 'upload';

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
