<?php

use App\Services\OrderTypes\TypeCheckers;

return [
    'type_checkers' => [
        'bag' => TypeCheckers\CheckForBagOrder::class,
        'late' => TypeCheckers\CheckForLateOrder::class,
        'rush' => TypeCheckers\CheckForRushOrder::class,
        'new' => TypeCheckers\CheckForNewOrder::class,
        'prototype' => TypeCheckers\CheckForPrototypeOrder::class,
        'ninas' => TypeCheckers\CheckForNinasOrder::class,
        'px' => TypeCheckers\CheckForPxOrder::class,
        'sp' => TypeCheckers\CheckForSpOrder::class,
        'rf' => TypeCheckers\CheckForRfOrder::class,
        'hj' => TypeCheckers\CheckForHjOrder::class,
    ],
];
