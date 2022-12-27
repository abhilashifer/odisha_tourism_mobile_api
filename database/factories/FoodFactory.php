<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Food;
use Faker\Generator as Faker;

$factory->define(Food::class, function (Faker $faker) {
    return [
        'master_subcategory_id' => $faker->numberBetween(1, 50),
        'name' => $faker->word(),
        'food_type' => $faker->randomElement(['veg', 'non-veg']),
        'thumbnail' => $faker->imageUrl(640, 480),
        'des_short' => $faker->sentence(8),
        'des_long' => $faker->paragraph(10),
    ];
});
