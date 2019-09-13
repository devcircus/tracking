<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ink;
use App\Models\Printer;
use Faker\Generator as Faker;

$factory->define(Printer::class, function (Faker $faker) {
    return [
        'name' => $faker->word.' '.$faker->word,
        'model' => $faker->word,
        'ink_id' => factory(Ink::class)->create()->id,
        'manufacturer' => $faker->company,
    ];
});
