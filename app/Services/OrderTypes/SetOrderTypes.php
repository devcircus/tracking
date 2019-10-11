<?php

namespace App\Services\OrderTypes;

use App\Models\Type;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use PerfectOblivion\Services\Traits\SelfCallingService;

class SetOrderTypes
{
    use SelfCallingService;

    /**
     * Get all order types for the given order.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return array
     */
    public function run(Model $model)
    {
        $types = $this->determineTypesForModel($model);

        return $model->types()->sync($this->translateTypesToModels($types));
    }

    /**
     * Determine the types for the given Model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    private function determineTypesForModel(Model $model): Collection
    {
        return collect(config('sublimation.type_checkers'))->filter(function ($checker) use ($model) {
            return $checker::call($model);
        })->keys();
    }

    /**
     * Translate the types to the associated Type model.
     *
     * @param  \Illuminate\Support\Collection  $types
     */
    private function translateTypesToModels(Collection $types): Collection
    {
        return $types->map(function ($type) {
            return Type::whereType($type)->first()->id;
        });
    }
}
