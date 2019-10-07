<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categories;
use Faker\Generator as Faker;

$factory->define(Categories::class, function (Faker $faker) {

    $name = $faker->realText(10);

    return [
        'name' => $name,
        'is_active' => 1
    ];
});
