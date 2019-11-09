<?php

use Faker\Generator as Faker;

$factory->define(App\Song::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'artist' => $faker->name,
        'tempo' => $faker->numberBetween(40, 200),
        'original_song' => '--',
        'song_cover' => false,
        'author_id' => 1,
        'chord' => $faker->paragraphs(1, true),
        'lyrics' => $faker->paragraphs(5, true),
    ];
});
