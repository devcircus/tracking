<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ink;
use Faker\Generator as Faker;

$factory->define(Ink::class, function (Faker $faker) {
    $types = ['standard', 'neon'];

    return [
        'manufacturer' => $faker->company,
        'version' => $faker->word,
        'type' => $types[rand(0,1)],
    ];
});
