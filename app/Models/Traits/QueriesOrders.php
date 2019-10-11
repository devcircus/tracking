<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait QueriesOrders
{
    /**
     * Get all vouchers for the specified date.
     *
     * @param  string  $date
     */
    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->where('report_created', $date)->orderBy('schedule_date', 'asc')->orderBy('order_number', 'asc')->orderBy('voucher', 'asc');
    }

    /**
     * Get all vouchers not marked complete.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     */
    public function scopeNotComplete(Builder $query, string $type): Builder
    {
        if ('prototype' === $type) {
            return $query->where('sew_house', 'NS')->whereNull('print_complete');
        } elseif ('production' === $type) {
            return $query->where('sew_house', '34')->where('cut_house', 'SU');
        }
    }

    /**
     * Get the order quantity for a given date.
     *
     * @param  string  $date
     */
    public function getQuantityForDate(string $date): int
    {
        return $this->forDate($date)->get()->sum('quantity');
    }

    /**
     * Does the given report_created date exist in the db?
     *
     * @param  string  $date
     */
    public function hasDate(string $date): bool
    {
        return $this->where('report_created', $date)->exists();
    }

    /**
     * Calculate the totals, grouped by date.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWeeklyTotals(Builder $query): array
    {
        return $query->get()->groupBy('schedule_date')->map(function ($group) {
            return $group->sum(function ($group) {
                return $group['quantity'];
            });
        })->toArray();
    }

    /**
     * Count the number of vouchers, grouped by date.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWeeklyVouchers(Builder $query): array
    {
        return $query->get()->groupBy('schedule_date')->map(function ($group) {
            return $group->count();
        })->toArray();
    }
}
