<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Upload;
use Illuminate\Console\Command;

class ClearOldReports extends Command
{
    /** @var \App\Models\Order */
    private $orders;

    /** @var \App\Models\Upload */
    private $uploads;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear reports older than two weeks.';

    /**
     * Create a new command instance.
     *
     * @param  \App\Models\Order  $orders
     * @param  \App\Models\Upload  $uploads
     */
    public function __construct(Order $orders, Upload $uploads)
    {
        $this->orders = $orders;
        $this->uploads = $uploads;

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->comment('Deleting records older than 2 weeks...');

        $this->orders->where('report_created', '<', now()->subDays(14))->delete();
        $this->uploads->where('uploaded_at', '<', now()->subDays(14))->delete();

        $this->comment('Old records were successfully cleared!');
    }
}
