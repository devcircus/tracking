<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Services\CachedService;
use Illuminate\Support\Facades\DB;
use PerfectOblivion\Services\Traits\SelfCallingService;

class BuildDashboardData extends CachedService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new BuildDashboardData Service.
     *
     * @param  \App\Models\Order  $orders
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Build the data for the dashboard.
     *
     * @return array
     */
    public function run()
    {
        return $this->getPaginatedData();
    }

    /**
     * Retrieve paginated data for the dashboard.
     *
     * @return array
     */
    private function getPaginatedData()
    {
        $dates = key_by_values($this->orders->reportDates()->toArray());

        return collect($dates)->map(function ($date) {
            return [
                'quantities' => DB::table('orders')
                    ->where('report_created', $date)
                    ->selectRaw('count(*) as total')
                    ->selectRaw("count(case when sew_house = 'NS' and print_house = '' then 1 end) as new")
                    ->selectRaw("count(case when sew_house = 'NS' and print_complete is null then 1 end) as prototype")
                    ->selectRaw("count(case when (print_house = 'NS' and CURDATE() > schedule_date) or (sew_house = '34' and cut_house = 'SU' and date_add(CURDATE(), INTERVAL 7 DAY) >= schedule_date) then 1 end) as late")
                    ->selectRaw("count(case when sew_house = 'NS' and print_complete is null and rush_date is not null then 1 end) as rush")
                    ->selectRaw("count(case when sew_house = '34' and cut_house = 'SU' then 1 end) as production")
                    ->selectRaw("count(case when sew_house = 'RY' and cut_house = 'SU' then 1 end) as bag")
                    ->first(),
                'date' => $date,
                'date_string' => display_date_time($date),
                'timestamp' => to_timestamp($date),
            ];
        })->paginate();
    }
}
