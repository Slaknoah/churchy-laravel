<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {
    $page_name = $faker->words(2, true);
    return [
        'title' => $page_name,
        'slug' => str_slug($page_name),
        'content' => $faker->paragraphs(7, true),
        'template' => 'default',
        'author_id' => 1,
    ];
});
