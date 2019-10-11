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
     */
    function display_date($date): Carbon
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
     */
    function display_date_time($date, string $from = 'Y-m-d H:i:s'): Carbon
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
     */
    function to_date_string($date, string $from = 'Y-m-d H:i:s'): string
    {
        return Carbon::createFromFormat($from, $date)->toDateString();
    }
}

if (! function_exists('to_timestamp')) {
    /**
     * Get the timestamp of a date in the given format.
     *
     * @param  string  $date
     * @param  string  $from
     */
    function to_timestamp($date, string $from = 'Y-m-d H:i:s'): int
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
     */
    function full_date_time_string($date, $from = 'Y-m-d H:i:s'): string
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
     */
    function date_is_valid($date): bool
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
     */
    function array_key($element, string $key): array
    {
        return [$key => $element];
    }
}

if (! function_exists('key_by_values')) {
    /**
     * Wrap an item in an array with the given key.
     *
     * @param  mixed  $element
     */
    function key_by_values($array): array
    {
        return array_combine($array, $array);
    }
}
