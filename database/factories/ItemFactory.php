<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => str_limit(strtoupper($faker->word()), 4, ''),
        'minimum' => rand(0, 10),
    ];
});
