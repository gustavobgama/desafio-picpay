<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Consumer;

$factory->define(Consumer::class, function (Faker $faker) {
    return [
        'balance' => 0,
    ];
});
