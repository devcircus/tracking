<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use App\Models\Order;

class ConvertDate
{
    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new GetWorkingDateService.
     *
     * @param  \App\Models\Order  $orders
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $formattedDate = null;

        if ($date = $request->date) {
            $d = DateTime::createFromFormat('U', $date);
            abort_unless($d && $d->format('U') == $date, 500, 'The given date is invalid.');
            if ($this->orders->hasDate($formatted = $d->format('Y-m-d H:i:s'))) {
                $formattedDate = $formatted;
            }
        }

        $request->merge([
            'date' => $formattedDate,
            'timestamp' => strtotime($formattedDate),
        ]);

        return $next($request);
    }
}
