<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForPrototypeOrder
{
    use SelfCallingService;

    /**
     * Check if the order is for a prototype.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return bool
     */
    public function run(Model $model)
    {
        if ('NS' === $model->sew_house) return true;
    }
}
