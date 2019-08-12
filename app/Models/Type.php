<?php

namespace App\Models;

class Type extends Model
{
    /** @var string */
    protected $table = 'types';

    /**
     * A Type belongs to many Orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
