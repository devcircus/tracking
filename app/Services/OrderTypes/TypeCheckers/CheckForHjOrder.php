<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForHjOrder
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
        if ('HJPOLY' === $model->style && 'SU' === $model->sew_house && 'SU' === $model->cut_house) {
            return true;
        }

        return false;
    }
}
