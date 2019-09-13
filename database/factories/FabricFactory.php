<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Fabric;
use Faker\Generator as Faker;

$factory->define(Fabric::class, function (Faker $faker) {
    $word = $faker->word.$faker->word.$faker->word;
    $speeds = [2.8, 3.4];
    $cross_grain = [0,1];

    return [
        'code' => strtoupper(substr($word, 0, 4)),
        'name' => $faker->word.' '.$faker->word,
        'cross_grain' => $cross_grain[rand(0,1)],
        'press_speed' => $speeds[rand(0,1)],
        'manufacturer' => $faker->company,
    ];
});
