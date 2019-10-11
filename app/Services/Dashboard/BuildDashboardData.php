<?php

namespace App\Services\Dashboard;

use App\Models\Order;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use PerfectOblivion\Services\Traits\SelfCallingService;

class BuildDashboardData
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /** @var \App\Models\Upload */
    private $uploads;

    /**
     * Construct a new BuildDashboardData Service.
     *
     * @param  \App\Models\Order  $orders
     * @param  \App\Models\Upload  $uploads
     */
    public function __construct(Order $orders, Upload $uploads)
    {
        $this->orders = $orders;
        $this->uploads = $uploads;
    }

    /**
     * Build the data for the dashboard.
     */
    public function run(): array
    {
        return $this->getPaginatedData();
    }

    /**
     * Retrieve paginated data for the dashboard.
     */
    private function getPaginatedData(): array
    {
        $dates = key_by_values($this->orders->reportDates()->toArray());

        return collect($dates)->reject(function ($date) {
            return $this->uploads->uploadInProgressForDate($date);
        })->map(function ($date) {
            return [
                'quantities' => DB::table('orders')
                    ->where('report_created', $date)
                    ->selectRaw('count(*) as total')
                    ->selectRaw("count(case when sew_house = 'NS' and print_house = '' then 1 end) as new")
                    ->selectRaw("count(case when sew_house = 'SU' and cut_house = 'SU' and style = 'HJPOLY' then 1 end) as hj")
                    ->selectRaw("count(case when sew_house = 'NS' and print_complete is null then 1 end) as prototype")
                    ->selectRaw("count(case when (print_house = 'NS' and CURDATE() > schedule_date) or (sew_house = '34' and cut_house = 'SU' and date_add(CURDATE(), INTERVAL 7 DAY) >= schedule_date) then 1 end) as late")
                    ->selectRaw("count(case when sew_house = 'NS' and print_complete is null and rush_date is not null then 1 end) as rush")
                    ->selectRaw("count(case when sew_house = '34' and cut_house = 'SU' then 1 end) as ninas")
                    ->selectRaw("count(case when sew_house = 'PX' and cut_house = 'SU' then 1 end) as px")
                    ->selectRaw("count(case when sew_house = 'SP' and cut_house = 'SU' then 1 end) as sp")
                    ->selectRaw("count(case when sew_house = 'RF' and cut_house = 'SU' then 1 end) as rf")
                    ->selectRaw("count(case when sew_house = 'RY' and cut_house = 'SU' then 1 end) as bag")
                    ->first(),
                'date' => $date,
                'date_string' => display_date_time($date),
                'timestamp' => to_timestamp($date),
            ];
        })->paginate();
    }
}
