<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {

    $title = $faker->slug(10,'-');
    $sub_title = $faker->realText(20);
    $description = $faker->realText(100);

    return [
        'user_id' => 1,
        'description' => $description,
        'image' => 'test_blog_image.jpg',
        'title' => $title,
        'sub_title' => $sub_title,
        'is_published' => 1,
        'published_at' => now(),
    ];
});
