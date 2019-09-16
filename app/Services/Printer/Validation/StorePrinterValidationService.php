<?php

namespace App\Services\Printer\Validation;

use Illuminate\Validation\Rule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class StorePrinterValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'unique:printers,name'],
            'model' => ['required', 'string', 'min:3'],
            'manufacturer' => ['required', 'string', 'min:3'],
            'ink_id' => ['required', 'numeric', Rule::exists('inks', 'id')],
            'copy_printer_id' => ['nullable', 'numeric', Rule::exists('printers', 'id')],
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
            'model' => ['trim', 'strip_tags'],
            'manufacturer' => ['trim', 'strip_tags'],
        ];
    }
}
