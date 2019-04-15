<?php

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'job_title' => $faker->title,
        'email' => $faker->unique()->safeEmail,
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'registered_since' => date('Y-m-d H:i:s'),
        'phone' => Str::random(10)
    ];
});
