<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForBagOrder
{
    use SelfCallingService;

    /**
     * Check if the order is for a bag.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function run(Model $model): bool
    {
        return 'RY' === $model->sew_house && 'SU' === $model->cut_house ? true : false;
    }
}
