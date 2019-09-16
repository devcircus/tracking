<?php

namespace App\Services\Materials;

use App\Models\Color;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListColorsService
{
    use SelfCallingService;

    /** @var \App\Models\Color */
    private $colors;

    /**
     * Construct a new ListColorsService.
     *
     * @param  \App\Models\Color  $colors
     */
    public function __construct(Color $colors)
    {
        $this->colors = $colors;
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->colors->withTrashed()->get();
    }
}
