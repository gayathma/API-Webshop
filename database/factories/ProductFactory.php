<?php

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->title,
        'price'		   => $faker->randomNumber(2)
    ];
});
