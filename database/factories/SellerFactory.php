<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Seller;

$factory->define(Seller::class, function (Faker $faker) {
    return [
        'cnpj' => $faker->cnpj(false),
        'fantasy_name' => $faker->company,
        'social_name' => $faker->company,
    ];
});
