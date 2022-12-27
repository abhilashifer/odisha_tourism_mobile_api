<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TouristDestination;
use Faker\Generator as Faker;

$factory->define(TouristDestination::class, function (Faker $faker) {
    return [
        'name' => $faker->city(),
        'trip_type' => $faker->randomElement(['family trip', 'couple trip', 'single trip', 'friends trip']),
        'loc_cord' => $faker->latitude() . ',' . $faker->longitude(),
        'thumbnail' => $faker->imageUrl(640, 480),
        'address' => $faker->address(),
        'district_id' => $faker->numberBetween(1, 28),
        'destination_category_id' => $faker->numberBetween(1, 30),
        'email' => $faker->email(),
        'mobile_number' => $faker->e164PhoneNumber(),
        'website' => $faker->url(),
        'des_short' => $faker->sentence(10),
        'des_long' => $faker->paragraph(8)

    ];
});
