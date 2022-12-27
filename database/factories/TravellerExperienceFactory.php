<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TravellerExperience;
use Faker\Generator as Faker;

$factory->define(TravellerExperience::class, function (Faker $faker) {
    return [
        'thumbnail' => $faker->imageUrl(640, 480),
        'media_data' => json_encode(['title' => $faker->word(), 'link' => $faker->imageUrl(640, 480)]),
        'active' => $faker->boolean()
    ];
});
