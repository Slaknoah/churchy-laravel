<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'title' => $faker->text(70),
        'speaker_id' => 8,
        'description' => $faker->paragraphs(4, true),
        'media' => null,
        'cover_image' => null,
        'author_id' => 1,
        'series_id' => 1,
    ];
});
