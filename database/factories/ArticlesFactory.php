<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(70),
        'content' => $faker->paragraphs(6, true),
        'cover_image' => false,
        'author_id' => 1,
        'series_id' => 1
    ];
});
