<?php

namespace App\Services\Fabric\Validation;

use Illuminate\Validation\Rule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdateFabricValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'string', 'min:3', Rule::unique('fabrics', 'code')->ignore($this->validationData()['id'])],
            'name' => ['required', 'string', 'min:3', Rule::unique('fabrics', 'name')->ignore($this->validationData()['id'])],
            'cross_grain' => ['required', 'boolean'],
            'press_speed' => ['required', 'numeric'],
            'manufacturer' => ['required', 'string', 'min:3'],
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
            'code' => ['trim', 'strip_tags'],
            'manufacturer' => ['trim', 'strip_tags'],
        ];
    }
}
