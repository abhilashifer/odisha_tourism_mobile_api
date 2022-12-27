<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Accomodation;
use Faker\Generator as Faker;

$factory->define(Accomodation::class, function (Faker $faker) {
    return [
        'name' => $faker->company(),
        'accomodation_cat_id' => $faker->numberBetween(1, 7),
        'district_id' => $faker->numberBetween(1, 28),
        'thumbnail' => $faker->imageUrl(640, 480),
        'address' => $faker->address(),
        'des_short' => $faker->sentence(8),
        'des_long' => $faker->paragraph(10),
        'loc_cord' => $faker->latitude() . ',' . $faker->longitude(),
        'mobile_number' => $faker->e164PhoneNumber(),
        'email' => $faker->email(),
        'website' => $faker->url()
    ];
});
