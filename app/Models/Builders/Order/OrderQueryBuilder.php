<?php

namespace App\Models\Builders\Order;

use Illuminate\Database\Eloquent\Builder;

class OrderQueryBuilder extends Builder
{
    use OrderBuilderScopes;
    use OrderBuilderActions;
}
