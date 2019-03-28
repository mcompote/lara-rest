<?php

use Faker\Generator as Faker;
use \App\Product;


$factory->define(Product::class, function (Faker $faker) {

    return [
        'name' => join(' ', $faker->words(rand(1,10))),
        'description' => $faker->text(200)
    ];
});
