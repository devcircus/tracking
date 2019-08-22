<?php

use Illuminate\Support\Carbon;

if (! function_exists('redirect_if')) {
    /**
     * Redirect to the given route,url, or action if the given condition is true.
     *
     * @param  mixed  $condition
     * @param  string  $route
     * @param  array  $parameters
     *
     * @return mixed
     */
    function redirect_if($condition, $route, ?array $parameters = [])
    {
        if (! $condition) {
            return;
        }

        return $parameters ? redirect($route)->with($parameters) : redirect($route);
    }
}

if (! function_exists('redirect_unless')) {
    /**
     * Redirect to the given route,url, or action unless the given condition is true.
     *
     * @param  mixed  $condition
     * @param  string  $route
     * @param  array  $parameters
     *
     * @return mixed
     */
    function redirect_unless($condition, $route, ?array $parameters = [])
    {
        if ($condition) {
            return;
        }

        return $parameters ? redirect($route)->with($parameters) : redirect($route);
    }
}

if (! function_exists('display_date')) {
    /**
     * Convert a date to a displayable format.
     *
     * @param  string  $date
     *
     * @return \Illuminate\Support\Carbon
     */
    function display_date($date)
    {
        return $date ? to_date_string($date) : '';
    }
}

if (! function_exists('display_date_time')) {
    /**
     * Convert a date to a displayable format.
     *
     * @param  string  $date
     * @param  string  $from
     *
     * @return \Illuminate\Support\Carbon
     */
    function display_date_time($date, string $from = 'Y-m-d H:i:s')
    {
        return $date ? Carbon::createFromFormat($from, $date)->format('m/d/y g:i a') : '';
    }
}

if (! function_exists('to_date_string')) {
    /**
     * Get a DateString from the given date format.
     *
     * @param  string  $date
     * @param  string  $from
     *
     * @return string
     */
    function to_date_string($date, string $from = 'Y-m-d H:i:s')
    {
        return Carbon::createFromFormat($from, $date)->timezone('America/Chicago')->toDateString();
    }
}

if (! function_exists('to_timestamp')) {
    /**
     * Get the timestamp of a date in the given format.
     *
     * @param  string  $date
     * @param  string  $from
     *
     * @return int
     */
    function to_timestamp($date, string $from = 'Y-m-d H:i:s')
    {
        return Carbon::createFromFormat($from, $date)->timestamp;
    }
}

if (! function_exists('full_date_time_string')) {
    /**
     * Get the timestamp of a date in the given format.
     *
     * @param  string  $date
     * @param  string  $from
     *
     * @return string
     */
    function full_date_time_string($date, $from = 'Y-m-d H:i:s')
    {
        $date = Carbon::createFromFormat($from, $date);
        $date->setTimezone('America/Chicago');

        return $date->format('l, F jS @ h:i A');
    }
}

if (! function_exists('date_is_valid')) {
    /**
     * Check if the given date is considered valid for a report.
     *
     * @param  string  $date
     *
     * @return bool
     */
    function date_is_valid($date)
    {
        if ('0' == $date || '00/00/00' == $date || null == $date) {
            return false;
        }

        return true;
    }
}

if (! function_exists('array_key')) {
    /**
     * Wrap an item in an array with the given key.
     *
     * @param  mixed  $element
     * @param  string  $key
     *
     * @return array
     */
    function array_key($element, string $key)
    {
        return [$key => $element];
    }
}

if (! function_exists('key_by_values')) {
    /**
     * Wrap an item in an array with the given key.
     *
     * @param  mixed  $element
     *
     * @return array
     */
    function key_by_values($array)
    {
        return array_combine($array, $array);
    }
}
