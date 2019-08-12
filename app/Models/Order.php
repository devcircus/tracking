<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\Traits\QueriesOrders;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\FormatsOrderDates;
use App\Services\OrderTypes\SetOrderTypes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use QueriesOrders;
    use FormatsOrderDates;

    /** @var string */
    const COMPLETE = 'COMPLETE';

    /** @var array */
    protected $appends = [
        'order_types',
    ];

    /** @var array */
    protected $dates = [
        'print_complete',
    ];

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
     * Query scope for Order type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->whereHas('types', function ($q) use ($type) {
            $q->where('type', $type);
        });
    }

    /**
     * Scope to exclude a certain column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     */
    public function scopeExclude($query, $value = []): Builder
    {
        return $query->select(array_diff($this->columns, (array) $value));
    }

    /**
     * Fetch all dates on which orders were created.
     */
    public function reportDates(): Collection
    {
        return $this->query()->orderBy('report_created', 'desc')->groupBy('report_created')->pluck('report_created');
    }

    /**
     * Add an order.
     *
     * @param  array  $data
     */
    public function saveOrder(array $data): Order
    {
        $order = $this->updateOrCreate([
            'order_number' => $data['order_number'],
            'voucher' => $data['voucher'],
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
            'report_created' => $data['report_created'],
            'info' => $data['info'],
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
     */
    public function markAsComplete(): Order
    {
        return tap($this, function ($instance) {
            $start = now();
            $instance->print_start = $start;
            $instance->print_complete = $start;
            $instance->info = $instance::COMPLETE.' - '.$instance->print_complete->format('m/d');
            $instance->setCutHouseForCompletedOrder($instance);
            $instance->save();
        })->fresh();
    }

    /**
     * Delete an order.
     */
    public function deleteOrder(): Order
    {
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
     *
     * @return array
     */
    public function batchUpdateInfo(array $info)
    {
        $all = collect($info)->each(function ($item, $key) {
            $this->find($key)->update(['info' => $item]);
        });

        return $all;
    }
}
