<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForPxOrder
{
    use SelfCallingService;

    /**
     * Check if the order is for Px.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function run(Model $model): bool
    {
        if ('SU' === $model->cut_house && 'PX' === $model->sew_house) {
            return true;
        }

        return false;
    }
}
