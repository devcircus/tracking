<?php

namespace App\Rules;

use App\Models\InventoryItem;
use PerfectOblivion\Valid\CustomRule;

class ItemHasNoTagsRule extends CustomRule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $item = InventoryItem::find($value);

        return ! $item->hasTags();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Item has tags associated with it and cannot be deleted.';
    }
}
