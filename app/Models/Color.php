<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use SoftDeletes;

    /**
     * A color belongs to many Printers.
     */
    public function printers(): BelongsToMany
    {
        return $this->belongsToMany(Printer::class)->withPivot(['cyan', 'magenta', 'yellow', 'black', 'approved']);
    }
}
