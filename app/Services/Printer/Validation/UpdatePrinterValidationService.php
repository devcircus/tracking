<?php

namespace App\Services\Printer\Validation;

use Illuminate\Validation\Rule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdatePrinterValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('printers', 'name')->ignore($this->validationData()['id'])],
            'model' => ['required', 'string', 'min:3'],
            'manufacturer' => ['required', 'string', 'min:3'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'name' => ['trim', 'strip_tags'],
            'model' => ['trim', 'strip_tags'],
            'manufacturer' => ['trim', 'strip_tags'],
        ];
    }
}
