<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\InventoryItem;
use Faker\Generator as Faker;

$factory->define(InventoryItem::class, function (Faker $faker) {
    return [
        'name' => str_limit(strtoupper($faker->word()), 4, ''),
        'minimum' => rand(0, 10),
    ];
});
