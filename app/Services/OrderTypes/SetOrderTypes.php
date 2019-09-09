<?php

namespace App\Services\OrderTypes;

use App\Models\Type;
use Illuminate\Database\Eloquent\Model;
use App\Services\OrderTypes\TypeCheckers;
use PerfectOblivion\Services\Traits\SelfCallingService;

class SetOrderTypes
{
    use SelfCallingService;

    /** @var array */
    public $checkers = [
        'bag' => TypeCheckers\CheckForBagOrder::class,
        'late' => TypeCheckers\CheckForLateOrder::class,
        'rush' => TypeCheckers\CheckForRushOrder::class,
        'new' => TypeCheckers\CheckForNewOrder::class,
        'prototype' => TypeCheckers\CheckForPrototypeOrder::class,
        'ninas' => TypeCheckers\CheckForNinasOrder::class,
        'px' => TypeCheckers\CheckForPxOrder::class,
        'sp' => TypeCheckers\CheckForSpOrder::class,
        'rf' => TypeCheckers\CheckForRfOrder::class,
    ];

    /**
     * Get all order types for the given order.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return array
     */
    public function run(Model $model)
    {
        $found = collect($this->checkers)->filter(function ($checker) use ($model) {
            return $checker::call($model);
        })->keys()->toArray();

        return $model->types()->sync(collect($found)->map(function ($type) {
                return Type::whereType($type)->first()->id;
            })
        );
    }
}
