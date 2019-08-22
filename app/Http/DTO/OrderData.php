<?php

namespace App\Http\DTO;

use Illuminate\Http\Request;

class OrderData extends Data
{
    /** @var string */
    public $schedule_date;

    /** @var string */
    public $order_number;

    /** @var string */
    public $voucher;

    /** @var string|null */
    public $sew_house;

    /** @var string */
    public $quantity;

    /** @var string|null */
    public $print_house;

    /** @var string|null */
    public $print_complete;

    /** @var string|null */
    public $print_start;

    /** @var string|null */
    public $days;

    /** @var string|null */
    public $rush_date;

    /** @var string */
    public $customer;

    /** @var string */
    public $remake;

    /** @var string|null */
    public $received_date;

    /** @var string|null */
    public $cut_date;

    /** @var string */
    public $style;

    /** @var string|null */
    public $cut_house;

    /** @var string */
    public $report_created;

    /** @var string|null */
    public $info;

    /**
     * Construct a new InventoryItemData object.
     *
     * @param  array  $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct($this->validate($parameters));
    }

    /**
     * Create a new OrderData from a request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public static function fromRequest(Request $request): OrderData
    {
        return static::fromArray($request->all());
    }

    /**
     * Create a new OrderData from a request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public static function fromArray(array $data): OrderData
    {
        return new static([
            'schedule_date' => $data['schedule_date'],
            'order_number' => $data['order_number'],
            'voucher' => $data['voucher'],
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
    }

    /**
     * Validate the given parameters.
     *
     * @param  array  $parameters
     */
    public function validate(array $parameters): array
    {
        return $parameters;
    }
}
