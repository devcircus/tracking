<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForNinasOrder
{
    use SelfCallingService;

    /**
     * Check if the order is for Ninas.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function run(Model $model): bool
    {
        if ('SU' === $model->cut_house && '34' === $model->sew_house) {
            return true;
        }

        return false;
    }
}
