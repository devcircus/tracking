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
     */
    public function passes($attribute, $value): bool
    {
        $item = InventoryItem::find($value);

        return ! $item->hasTags();
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'Item has tags associated with it and cannot be deleted.';
    }
}
