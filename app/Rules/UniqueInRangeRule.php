<?php

namespace App\Rules;

use App\Models\Tag;
use PerfectOblivion\Valid\CustomRule;

class UniqueInRangeRule extends CustomRule
{
    /** @var int */
    private $exists;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = $this->validator->getData();
        $start = $data['starting_package_number'];
        $end = $data['ending_package_number'];

        foreach(range($start, $end) as $packageNumber) {
            if (Tag::where('package_number', $packageNumber)->first()) {
                $this->exists = $packageNumber;
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Package number {$this->exists} already exists. Exclude this package from the given range.";
    }
}
