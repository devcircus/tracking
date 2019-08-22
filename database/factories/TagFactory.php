<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Tag;
use App\Models\InventoryItem;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'item_id' => factory(InventoryItem::class),
        'package_number' => $faker->randomNumber(7, $strict = true),
        'received_at' => now()->subDays(rand(60, 180)),
        'finished_at' => 0 === (rand(1, 2) % 2) ? now()->subDays(rand(0, 40)) : null,
    ];
});
