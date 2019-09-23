<?php

namespace App\Services\Materials;

use App\Models\Printer;
use App\Services\Cache\CacheForeverService;
use Illuminate\Database\Eloquent\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListPrintersService
{
    use SelfCallingService;

    /** @var \App\Models\Printer */
    private $printers;

    /**
     * Construct a new ListPrintersService.
     *
     * @param  \App\Models\Printer  $printers
     */
    public function __construct(Printer $printers)
    {
        $this->printers = $printers;
    }

    /**
     * Handle the call to the service.
     *
     * @param  string|null  $type
     * @param  bool  $withTrashed
     */
    public function run(?string $type = null, bool $withTrashed = true): Collection
    {
        return $type
        ? $this->printers->whereHas('ink', function ($query) use ($type, $withTrashed) {
            return $query->withTrashed($withTrashed)->where('type', $type);
        })->get()
        : CacheForeverService::call('printers', function() use ($withTrashed) {
            return $this->printers->withTrashed($withTrashed)->get();
        });
    }
}
