<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForRushOrder
{
    use SelfCallingService;

    /**
     * Check if the order is on rush status.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function run(Model $model): bool
    {
        if (null === $model->rush_date) return false;
        if ('00/00/00' === $model->rush_date) return false;
        if ('NS' === $model->sew_house) {
            if (null === $model->print_complete || '' === $model->print_complete) {
                return true;
            }
        }

        return false;
    }
}
