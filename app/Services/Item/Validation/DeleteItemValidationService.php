<?php

namespace App\Services\Item\Validation;

use App\Rules\ItemHasNoTagsRule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class DeleteItemValidationService extends ValidationService
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'item';

    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [new ItemHasNoTagsRule],
        ];
    }
}
