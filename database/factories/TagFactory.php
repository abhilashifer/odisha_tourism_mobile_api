<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'tag' => $faker->word(),
        'tag_meta' => $faker->sentence(5)
    ];
});
