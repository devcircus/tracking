<?php

namespace App\Models\Traits;

trait FormatsOrderDates
{
    /**
     * Return the schedule date as a FormattedDateString.
     *
     * @param  string  $date
     *
     * @return string
     */
    public function getReportCreatedAttribute(string $date)
    {
        return $date;
    }

    /**
     * Return the schedule date as a FormattedDateString.
     *
     * @param  string  $date
     *
     * @return string
     */
    public function getScheduleDateAttribute(string $date)
    {
        return display_date($date);
    }

    /**
     * Set the print_start attribute.
     *
     * @param  mixed  $value
     */
    public function setPrintStartAttribute($value)
    {
        $this->attributes['print_start'] = date_is_valid($value)
            ? date('Y-m-d H:i:s', strtotime($value))
            : null;
    }

    /**
     * Set the print_complete attribute.
     *
     * @param  mixed  $value
     */
    public function setPrintCompleteAttribute($value)
    {
        $this->attributes['print_complete'] = date_is_valid($value)
            ? date('Y-m-d H:i:s', strtotime($value))
            : null;
    }

    /**
     * Set the received_date attribute.
     *
     * @param  mixed  $value
     */
    public function setReceivedDateAttribute($value)
    {
        $this->attributes['received_date'] = date_is_valid($value)
            ? date('Y-m-d H:i:s', strtotime($value))
            : null;
    }

    /**
     * Set the cut_date attribute.
     *
     * @param  mixed  $value
     */
    public function setCutDateAttribute($value)
    {
        $this->attributes['cut_date'] = date_is_valid($value)
            ? date('Y-m-d H:i:s', strtotime($value))
            : null;
    }

    /**
     * Set the rush_date attribute.
     *
     * @param  mixed  $value
     */
    public function setRushDateAttribute($value)
    {
        $this->attributes['rush_date'] = date_is_valid($value)
            ? date('Y-m-d H:i:s', strtotime($value))
            : null;
    }

    /**
     * Set the schedule_date attribute.
     *
     * @param  mixed  $value
     */
    public function setScheduleDateAttribute($value)
    {
        $this->attributes['schedule_date'] = date_is_valid($value)
            ? date('Y-m-d H:i:s', strtotime($value))
            : null;
    }
}
