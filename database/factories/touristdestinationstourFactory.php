<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

$factory->define(DB::table('tourist_destinations_tours'), function (Faker $faker) {
    return [
        'tour_id' => $faker->numberBetween(1, 40),
        'tourist_destination_id' => $faker->numberBetween(1, 100)
    ];
});
