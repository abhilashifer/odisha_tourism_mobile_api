<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tour;
use Faker\Generator as Faker;

$factory->define(Tour::class, function (Faker $faker) {
    return [
        'master_subcategory_id' => $faker->numberBetween(1, 50),
        'district_id' => $faker->numberBetween(1, 28),
        'name' => $faker->word(),
        'tour_from' => $faker->city(),
        'tour_to' => $faker->city(),
        'des_short' => $faker->sentence(8),
        'des_long' => $faker->paragraph(10),
        'loc_cord' => $faker->latitude() . ',' . $faker->longitude(),
        'additional_info' => $faker->sentence(10)
    ];
});
