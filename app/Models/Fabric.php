<?php

namespace App\Models;

use App\Services\Cache\CacheForgetService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $casts = [
        'cross_grain' => 'boolean',
    ];

    /**
     * Add a new Fabric.
     *
     * @param  array  $data
     */
    public function addFabric(array $data): Fabric
    {
        CacheForgetService::call('fabrics');

        return $this->create($data);
    }

    /**
     * Update a Fabric.
     *
     * @param  array  $data
     */
    public function updateFabric(array $data): Fabric
    {
        CacheForgetService::call('fabrics');

        return tap($this, function ($instance) use ($data) {
            return $instance->update($data);
        })->fresh();
    }

    /**
     * Delete a Fabric.
     */
    public function deleteFabric(): Fabric
    {
        CacheForgetService::call('fabrics');

        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted Fabric.
     */
    public function restoreFabric(): Fabric
    {
        CacheForgetService::call('fabrics');

        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }
}
