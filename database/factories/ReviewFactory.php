<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'reviewable_id' => $faker->numberBetween(1, 100),
        'reviewable_type' => $faker->randomElement(['App\TouristDestination', 'app\Accomodation', 'App\Food', 'App\Tour', 'App\Activity', 'App\Event']),
        'body' => $faker->sentence(10),
        'additional_info' => $faker->sentence(),
        'rating' => $faker->numberBetween(1, 5)
    ];
});
