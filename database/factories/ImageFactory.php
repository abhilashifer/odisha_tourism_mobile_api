<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'img_path' => $faker->imageUrl(640, 480),
        'imageable_id' => $faker->numberBetween(1, 100),
        'imageable_type' => $faker->randomElement(['App\MajorCity', 'App\TouristDestination', 'App\Accomodation', 'App\Food', 'App\TravellerExperience', 'App\Tour', 'App\Activity', 'App\Event']),
        'des_short' => $faker->sentence(8)
    ];
});
