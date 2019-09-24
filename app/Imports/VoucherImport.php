<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Support\Carbon;
use App\Events\SpreadsheetUploaded;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class VoucherImport implements ToModel, WithHeadingRow, WithEvents, WithBatchInserts
{
    use Importable;
    use RegistersEventListeners;

    /** @static string */
    private static $reportCreated;

    /**
     * Process the import per bactch of rows from a sheet.
     *
     * @param  array  $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($this->rowShouldNotBeIgnored($row['ditem'])) {
            $print_complete = $row['cmpdte'];
            $existing = Order::latest('report_created')->where('order_number', $row['ordnr'])->where('voucher', $row['orvch'])->first();
            $art_complete = optional($existing)->art_complete;

            return new Order([
                'order_number' => $row['ordnr'],
                'voucher' => $row['orvch'],
                'sew_house' => $row['dhous'],
                'cut_house' => $row['htcut'],
                'style' => $row['ditem'],
                'customer' => $row['csnam'],
                'quantity' => $row['doqty'],
                'late_reason' => $row['dlrea'],
                'print_house' => '  ' == $row['prthse'] ? null : $row['prthse'],
                'days' => $row['inprocs'],
                'remake' => 'R' == $row['orrmk'] ? 1 : 0,
                'print_start' => $row['sntdte'],
                'print_complete' => $print_complete == 0 ? null : $print_complete,
                'received_date' => $row['rcddt'],
                'cut_date' => $row['cutdt'],
                'rush_date' => $row['rshdt'],
                'schedule_date' => $row['schdt'],
                'report_created' => $this::$reportCreated,
                'art_complete' => $art_complete,
                'info' => $this->getInfoForVoucher($existing, $print_complete),
            ]);
        }
    }

    /**
     * Set the date that the upload was created.
     *
     * @param  \Maatwebsite\Excel\Events\BeforeImport  $event
     */
    public static function beforeImport(BeforeImport $event): void
    {
        static::$reportCreated = now()->toDateTimeString();
    }

    /**
     * Dispatch event after spreadsheet is imported.
     *
     * @param  \Maatwebsite\Excel\Events\AfterImport  $event
     */
    public static function afterImport(AfterImport $event): void
    {
        SpreadsheetUploaded::broadcast(static::$reportCreated, auth()->user());
    }

    /**
     * Set the batch size for importing.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Should the current item be imported?
     *
     * @param  mixed  $item
     */
    private function rowShouldNotBeIgnored($item): bool
    {
        return ! $this->rowShouldBeIgnored($item);
    }

    /**
     * Should the current item be ignored?
     *
     * @param  mixed  $item
     */
    private function rowShouldBeIgnored($item): bool
    {
        return preg_match('/(^g?id)|(^cm)[a-z]?+[A-Z]?+[0-9]?+\s*?/i', $item);
    }

    /**
     * Get the info for the current item?
     *
     * @param  \App\Models\Order  $existingItem
     * @param  string  $printComplete
     */
    private function getInfoForVoucher($existingItem, $printComplete): string
    {
        if ($printComplete) {
            $displayDate = (new Carbon($printComplete))->format('m/d');

            return "COMPLETE - {$displayDate}";
        }

        return optional($existingItem)->info ?? '';
    }
}
