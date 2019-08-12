<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForNewOrder
{
    use SelfCallingService;

    /**
     * Check if the order is new.
     *
     * @param  \App\Models\Order  $order
     *
     * @return bool
     */
    public function run(Model $model)
    {
        if ((null === $model->print_house || '' === $model->print_house) && 'NS' === $model->sew_house) {
            return true;
        }
        return false;
    }
}
