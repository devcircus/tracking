<?php

namespace App\Http\DTO;

use Illuminate\Http\Request;

class ItemData extends Data
{

    /** @var int|null */
    public $id;

    /** @var string|null */
    public $name;

    /** @var int|null */
    public $minimum;

    /**
     * Construct a new ItemData object.
     *
     * @param  array  $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct($this->validate($parameters));
    }

    /**
     * Create a new ItemData object from request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public static function fromRequest(Request $request): ItemData
    {
        return static::fromArray($request->only(['id', 'name', 'minimum']));
    }

    /**
     * Create a new ItemData object from an array.
     *
     * @param  array  $data
     */
    public static function fromArray(array $data): ItemData
    {
        return new self([
            'id' => $data['id'] ?? null,
            'name' => $data['name'] ?? null,
            'minimum' => $data['minimum'] ?? null,
        ]);
    }

    /**
     * Validate the given parameters.
     *
     * @param  array  $parameters
     */
    public function validate(array $parameters): array
    {
        $parameters['id'] = isset($parameters['id']) ? (int) $parameters['id'] : null;
        $parameters['name'] = isset($parameters['name']) ? (string) $parameters['name'] : null;
        $parameters['minimum'] = isset($parameters['minimum']) ? (int) $parameters['minimum'] : null;

        return $parameters;
    }
}
