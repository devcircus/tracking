<?php

namespace App\Services\Color\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class SetColorValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'approved' => ['required', 'boolean'],
            'cyan' => ['required', 'numeric', 'min:0', 'max:100'],
            'magenta' => ['required', 'numeric', 'min:0', 'max:100'],
            'yellow' => ['required', 'numeric', 'min:0', 'max:100'],
            'black' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
