<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForSpOrder
{
    use SelfCallingService;

    /**
     * Check if the order is for Sp.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return bool
     */
    public function run(Model $model)
    {
        if ('SU' === $model->cut_house && 'SP' === $model->sew_house) {
            return true;
        }
        return false;
    }
}
