<?php

namespace App\Services\Order\Validation;

use Illuminate\Validation\Rule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class AddOrderServiceValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schedule_date' => ['required', 'date'],
            'order_number' => ['required', 'integer', 'min:100000'],
            'voucher' => ['required', 'integer', 'min:1'],
            'sew_house' => [
                'required',
                'string',
                Rule::in(['NS', 'CU', 'SR']),
            ],
            'quantity' => ['required', 'integer', 'min:1'],
            'print_house' => ['required'],
            'print_complete' => ['date', 'nullable'],
            'print_start' => ['date', 'nullable'],
            'days' => ['integer', 'nullable'],
            'rush_date' => ['date', 'nullable'],
            'customer' => ['string', 'min:2'],
            'remake' => [
                'nullable',
                'string',
                Rule::in(['1', '0']),
            ],
            'received_date' => ['date', 'nullable'],
            'cut_date' => ['date', 'nullable'],
            'style' => ['required', 'string'],
            'cut_house' => [
                'required',
                'string',
                Rule::in(['NS', 'CU', 'SU']),
            ],
            'report_created' => ['required', 'date'],
            'info' => ['string', 'min:3', 'nullable'],
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
        ];
    }
}
