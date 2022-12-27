<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MasterSubcategory;
use Faker\Generator as Faker;

$factory->define(MasterSubcategory::class, function (Faker $faker) {
    return [
        'master_category_id' => $faker->numberBetween(1, 7),
        'name' => $faker->word(),
        'thumbnail' => $faker->imageUrl(640, 480),
        'description' => $faker->sentence(8),
        'active' => $faker->boolean()
    ];
});
