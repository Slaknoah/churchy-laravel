<?php

use Faker\Generator as Faker;

$factory->define(App\Serie::class, function (Faker $faker) {
    return [
        'name' => $faker->text(15)
    ];
});
