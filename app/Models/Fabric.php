<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
    use SoftDeletes;

    /**
     * Add a new Fabric.
     *
     * @param  array  $data
     */
    public function addFabric(array $data): Fabric
    {
        return $this->create($data);
    }

    /**
     * Update a Fabric.
     *
     * @param  array  $data
     */
    public function updateFabric(array $data): Fabric
    {
        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        })->fresh();
    }

    /**
     * Delete a Fabric.
     */
    public function deleteFabric(): Fabric
    {
        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted Fabric.
     */
    public function restoreFabric(): Fabric
    {
        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }
}
