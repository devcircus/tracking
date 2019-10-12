<?php

namespace App\Models\Builders\Order;

trait OrderBuilderActions
{
    /**
     * Calculate the totals, grouped by date.
     */
    public function weeklyTotals(): array
    {
        return $this->get()->groupBy('schedule_date')->map(function ($group) {
            return $group->sum(function ($group) {
                return $group['quantity'];
            });
        })->toArray();
    }

    /**
     * Count the number of vouchers, grouped by date.
     */
    public function weeklyVouchers(): array
    {
        return $this->get()->groupBy('schedule_date')->map(function ($group) {
            return $group->count();
        })->toArray();
    }
}
