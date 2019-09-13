<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Color;
use Faker\Generator as Faker;

$factory->define(Color::class, function (Faker $faker) {
    $types = ['neon', 'standard'];

    return [
        'code' => strtoupper(substr($faker->word, 0, 3)),
        'name' => $faker->word,
        'type' => $types[rand(0, 1)],
    ];
});
