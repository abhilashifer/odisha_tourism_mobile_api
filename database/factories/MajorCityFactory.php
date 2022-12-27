<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MajorCity;
use Faker\Generator as Faker;

$factory->define(MajorCity::class, function (Faker $faker) {
    return [
        'name' => $faker->city(),
        'district_id' => $faker->numberBetween(1, 28),
        'desc_short' => $faker->sentence(6),
        'thumbnail' => $faker->imageUrl($width = 640, $height = 480)

    ];
});
