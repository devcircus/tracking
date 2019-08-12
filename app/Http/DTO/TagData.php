<?php

namespace App\Http\DTO;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class TagData extends Data
{
    /** @var int|null */
    public $item_id;

    /** @var int|null */
    public $package_number;

    /** @var \Carbon\CarbonImmutable|null */
    public $received_at;

    /** @var \Carbon\CarbonImmutable|null */
    public $finished_at;

    /**
     * Construct a new TagData object.
     *
     * @param  array  $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct($this->validate($parameters));
    }

    /**
     * Create a new TagData object from request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public static function fromRequest(Request $request): TagData
    {
        return static::fromArray($request->only(['item_id', 'package_number', 'received_at', 'finished_at']));
    }

    /**
     * Create a new TagData object from an array.
     *
     * @param  array  $data
     */
    public static function fromArray(array $data): TagData
    {
        return new self([
            'item_id' => $data['item_id'] ?? null,
            'package_number' => $data['package_number'] ?? null,
            'received_at' => $data['received_at'] ?? null,
            'finished_at' => $data['finished_at'] ?? null,
        ]);
    }

    /**
     * Validate the given parameters.
     *
     * @param  array  $parameters
     */
    public function validate(array $parameters): array
    {
        $receivedAt = $parameters['received_at'] ?? null;
        $finishedAt = $parameters['finished_at'] ?? null;

        $parameters['item_id'] = isset($parameters['item_id']) ? (string) $parameters['item_id'] : null;
        $parameters['package_number'] = isset($parameters['package_number']) ? (string) $parameters['package_number'] : null;

        if ($receivedAt) {
            if (is_string($receivedAt)) {
                $parameters['received_at'] = CarbonImmutable::createFromFormat('Y-m-d', $receivedAt);
            } elseif (! $receivedAt instanceof CarbonImmutable) {
                $parameters['received_at'] = null;
            }
        }

        if ($finishedAt) {
            if (is_string($finishedAt)) {
                $parameters['finished_at'] = CarbonImmutable::createFromFormat('Y-m-d', $finishedAt);
            } elseif (! $finishedAt instanceof CarbonImmutable) {
                $parameters['finished_at'] = null;
            }
        }


        return $parameters;
    }
}
