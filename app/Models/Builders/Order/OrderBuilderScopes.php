<?php

namespace App\Models\Builders\Order;

trait OrderBuilderScopes
{
    /**
     * Scope the query to retrieve orders with the given type.
     *
     * @param  string  $type
     */
    public function type(string $type): OrderQueryBuilder
    {
        return $this->whereHas('types', function ($q) use ($type) {
            $q->where('type', $type);
        });
    }

    /**
     * Scope the query to return only orders that are complete.
     */
    public function complete(): OrderQueryBuilder
    {
        return $this->whereNotNull('print_complete');
    }

    /**
     * Scope the query to return only orders that are NOT complete.
     *
     * @param  string  $type
     */
    public function notComplete(?string $type = 'prototype'): OrderQueryBuilder
    {
        if ('prototype' === $type) {
            return $this->whereNull('print_complete');
        } elseif ('production' === $type) {
            return $this->where('cut_house', 'SU');
        }
    }

    /**
     * Scope the query for orders for the specified date.
     *
     * @param  string  $date
     */
    public function forDate(string $date): OrderQueryBuilder
    {
        return $this->where('report_created', $date)->orderBy('schedule_date', 'asc')->orderBy('order_number', 'asc')->orderBy('voucher', 'asc');
    }
}
