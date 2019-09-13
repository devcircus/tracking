<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ink extends Model
{
    use SoftDeletes;

    /**
     * An Ink has many Printers.
     */
    public function printers(): HasMany
    {
        return $this->hasMany(Printer::class);
    }
}
