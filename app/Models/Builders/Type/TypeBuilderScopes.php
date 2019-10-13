<?php

namespace App\Models\Builders\Type;

trait TypeBuilderScopes
{
    /**
     * Scope the query to Types where type is the given type.
     *
     * @param  string|array  $types
     */
    public function whereType($types): TypeQueryBuilder
    {
        if (is_array($types)) {
            return $this->where(function($query) use ($types) {
                foreach($types as $type) {
                    $query->orWhere('type', $type);
                }
            });
        }

        return $this->where('type', $types);
    }
}
