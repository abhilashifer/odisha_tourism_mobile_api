<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 20),
        'likeable_type' => $faker->randomElement(['app\MajorCity', 'App\TouristDestination', 'app\Accomodation', 'App\Food', 'App\TravellerExperience', 'App\Tour', 'App\Activity', 'App\Event']),
        'likeable_id' => $faker->numberBetween(1, 100)
    ];
});
