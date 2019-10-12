<?php

namespace App\Models;

use App\Models\Builders\Type\TypeQueryBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    /** @var string */
    protected $table = 'types';

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new TypeQueryBuilder($query);
    }

    /**
     * A Type belongs to many Orders.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
