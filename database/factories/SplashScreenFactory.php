<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SplashScreen;
use Faker\Generator as Faker;

$factory->define(SplashScreen::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'thumbnail' => $faker->imageUrl(640, 480),
        'active' => $faker->boolean()
    ];
});
