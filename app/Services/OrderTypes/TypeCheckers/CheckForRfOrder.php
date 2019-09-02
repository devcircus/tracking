<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForRfOrder
{
    use SelfCallingService;

    /**
     * Check if the order is for Rf.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return bool
     */
    public function run(Model $model)
    {
        if ('SU' === $model->cut_house && 'RF' === $model->sew_house) {
            return true;
        }
        return false;
    }
}
