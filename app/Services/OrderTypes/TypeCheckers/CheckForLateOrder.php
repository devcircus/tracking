<?php

namespace App\Services\OrderTypes\TypeCheckers;

use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CheckForLateOrder
{
    use SelfCallingService;

    /**
     * Check if the order is late to schedule.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return bool
     */
    public function run(Model $model)
    {
        if (date_is_valid($model->schedule_date) && now() > $model->schedule_date && 'NS' === $model->print_house && ($model->print_complete === '' || (int)$model->print_complete === 0)) {
            return true;
        }
        if (date_is_valid($model->schedule_date) && now()->addWeek() >= $this->getScheduleDate($model) && '34' === $model->sew_house && 'SU' === $model->cut_house) {
            return true;
        }
    }
    /**
     * Get a formatted schedule date to be used for date comparison.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return string
     */
    public function getScheduleDate(Model $model)
    {
        return date('Y-m-d H:i:s', strtotime($model->schedule_date));
    }
}
