<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

trait HasUuids
{
    /**
     * Boot the trait.
     */
    protected static function bootHasUuids(): void
    {
        static::creating(function (Model $model) {
            $model->generateUuid();
        });
    }

    /**
     * There is no Uuid associated with the instance.
     */
    public function hasUuid(): bool
    {
        return ! is_null($this->uuid);
    }

    /**
     * There is a Uuid associated with the instance.
     */
    public function needsUuid(): bool
    {
        return ! $this->hasUuid();
    }

    /**
     * Generate a Uuid for a model.
     *
     * @return mixed
     */
    public function generateUuid()
    {
        if (! $this->needsUuid()) {
            return;
        }

        $this->uuid = Uuid::uuid4();
    }
}
