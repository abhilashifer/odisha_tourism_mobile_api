<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'master_subcategory_id' => $faker->numberBetween(1, 50),
        'district_id' => $faker->numberBetween(1, 28),
        'name' => $faker->word(),
        'event_address' => $faker->address(),
        'from_date' => $faker->date('Y-m_d'),
        'to_date' => $faker->date('Y-m-d'),
        'from_time' => $faker->time('H:i:s'),
        'to_time' => $faker->time('H:i:s'),
        'loc_cord' => $faker->latitude() . ',' . $faker->longitude(),
        'des_short' => $faker->sentence(8),
        'des_long' => $faker->paragraph(10),
        'mobile_number' => $faker->e164PhoneNumber(),
        'email' => $faker->email(),
        'website' => $faker->url(),
        'thumbnail' => $faker->imageUrl(640, 480),
    ];
});
