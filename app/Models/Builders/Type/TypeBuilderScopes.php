<?php

namespace App\Models\Builders\Type;

trait TypeBuilderScopes
{
    /**
     * Scope the query to Types where type is the given type.
     *
     * @param  string  $type
     */
    public function scopeWhereType(string $type): TypeQueryBuilder
    {
        return $this->where('type', $type);
    }
}
