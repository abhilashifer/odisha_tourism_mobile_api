<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MasterCategory;
use Faker\Generator as Faker;

$factory->define(MasterCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Event','Activity','Dayout','Nightout','Food','culture','sports']),
        'cat_type' => $faker->word(),
        'thumbnail' => $faker->imageUrl(640, 480),
        'active' => $faker->boolean()
    ];
});
