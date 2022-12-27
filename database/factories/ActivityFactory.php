<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'master_subcategory_id' => $faker->numberBetween(1, 50),
        'name' => $faker->word(),
        'des_short' => $faker->sentence(6),
        'des_long' => $faker->paragraph(8),
        'thumbnail' => $faker->imageUrl(640, 480),
        'loc_cord' => $faker->latitude() . ',' . $faker->longitude()
    ];
});
