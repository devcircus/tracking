<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\Traits\FormatsOrderDates;
use App\Services\Cache\CacheForgetService;
use App\Services\OrderTypes\SetOrderTypes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Builders\Order\OrderQueryBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use LogsActivity;
    use FormatsOrderDates;

    /** @var string */
    const COMPLETE = 'COMPLETE';

    /** @var array */
    protected $appends = [
        'order_types',
    ];

    /** @var bool */
    protected $casts = [
        'complete' => 'boolean',
        'manually_added' => 'boolean',
    ];

    /** @var array */
    protected $dates = [
        'art_complete',
        'print_complete',
    ];

    /** @var array */
    protected static $recordEvents = [];

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new OrderQueryBuilder($query);
    }

    /**
     * An Order belongs to many Types.
     */
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    /**
     * Accessor for Order types.
     */
    public function getOrderTypesAttribute(): array
    {
        return $this->types->map->type->toArray();
    }

    /**
     * Fetch all dates on which orders were created.
     */
    public function reportDates(): Collection
    {
        return $this->query()->orderBy('report_created', 'desc')->groupBy('report_created')->pluck('report_created');
    }

    /**
     * Fetch the most recent date for which reports were created.
     */
    public function mostRecentReportCreatedDate(): string
    {
        return $this->reportDates()->first();
    }

    /**
     * Does the given report_created date exist in the db?
     *
     * @param  string  $date
     */
    public function hasDate(string $date): bool
    {
        return $this->where('report_created', $date)->exists();
    }

    /**
     * Add an order.
     *
     * @param  array  $data
     */
    public function saveOrder(array $data): Order
    {
        CacheForgetService::call('reports', $data['report_created']);
        CacheForgetService::call('summary', $data['report_created']);

        $order = $this->updateOrCreate([
            'order_number' => $data['order_number'],
            'voucher' => $data['voucher'],
            'report_created' => $data['report_created'],
        ], [
            'schedule_date' => $data['schedule_date'],
            'sew_house' => $data['sew_house'],
            'quantity' => $data['quantity'],
            'print_house' => $data['print_house'],
            'print_complete' => $data['print_complete'],
            'print_start' => $data['print_start'],
            'days' => $data['days'],
            'rush_date' => $data['rush_date'],
            'customer' => $data['customer'],
            'remake' => $data['remake'],
            'received_date' => $data['received_date'],
            'cut_date' => $data['cut_date'],
            'style' => $data['style'],
            'cut_house' => $data['cut_house'],
            'info' => $data['info'],
            'manually_added' => true,
        ]);

        SetOrderTypes::call($order);

        return $order;
    }

    /**
     * Update the information for an order.
     *
     * @param  array  $data
     */
    public function updateOrder(array $data): Order
    {
        CacheForgetService::call('reports', $this->report_created);
        CacheForgetService::call('summary', $this->report_created);

        return tap($this, function ($instance) use ($data) {
            $instance->info = $data['info'];
            if (Str::contains($instance->info, $instance::COMPLETE)) {
                $date = now();
                $instance->print_start = $date;
                $instance->print_complete = $date;
                $instance->setCutHouseForCompletedOrder($instance);
            }

            return $instance->save();
        })->fresh();
    }

    /**
     * Mark an order as complete.
     *
     * @param  string|null  $date
     */
    public function markAsComplete(?string $date = null): Order
    {
        CacheForgetService::call('reports', $this->report_created);
        CacheForgetService::call('summary', $this->report_created);
        $date = $date ?? now();

        return tap($this, function ($instance) use ($date) {
            $instance->print_start = $date;
            $instance->print_complete = $date;
            $instance->info = $instance::COMPLETE.' - '.$instance->print_complete->format('m/d');
            $instance->setCutHouseForCompletedOrder($instance);
            $instance->save();
        })->fresh();
    }

    /**
     * Toggle the complete status of the order art.
     *
     * @return string|null
     */
    public function toggleArtComplete()
    {
        CacheForgetService::call('reports', $this->report_created);

        $current = $this->art_complete;
        $this->art_complete = $current ? null : now();
        $this->save();

        return $this->art_complete;
    }

    /**
     * Delete an order.
     */
    public function deleteOrder(): Order
    {
        CacheForgetService::call('reports', $this->report_created);
        CacheForgetService::call('summary', $this->report_created);

        return tap($this, function ($instance) {
            $instance->delete();
        });
    }

    /**
     * Set the Cut House for a completed order.
     *
     * @param  \App\Models\Order  $order
     */
    public function setCutHouseForCompletedOrder(Order $order): void
    {
        if (in_array('bag', $order->order_types)) {
            $order->cut_house = '34';
        } elseif (in_array('prototype', $order->order_types)) {
            $order->cut_house = 'NS';
        } elseif (in_array('production', $order->order_types)) {
            $order->cut_house = '34';
        }
    }

    /**
     * Update info for the given vouchers.
     *
     * @param  array  $info
     * @param  string  $date
     */
    public function batchUpdateInfo(array $info, string $date): Collection
    {
        CacheForgetService::call('reports', $date);
        CacheForgetService::call('summary', $date);

        return collect($info)->each(function ($item, $key) {
            if (Str::startsWith($item, 'COMPLETE')) {
                $date = trim(Str::after($item, '-')).'/'.date('y');

                return $this->find($key)->markAsComplete($date);
            }

            return $this->find($key)->update(['info' => $item]);
        });
    }
}
