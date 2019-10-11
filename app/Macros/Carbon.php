<?php

namespace App\Macros;

use Closure;
use OpenPsa\Ranger\Ranger;

class Carbon
{
    /**
     * Carbon Macro to create date range.
     */
    public function range(): Closure
    {
        return function ($to) {
            return (new Ranger('en'))->format(
                $this->toDateString(),
                $to->toDateString()
            );
        };
    }
}
