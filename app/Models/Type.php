<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    /** @var string */
    protected $table = 'types';

    /**
     * A Type belongs to many Orders.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * Scope the query to Types where type is the given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     */
    public function scopeWhereType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }
}
