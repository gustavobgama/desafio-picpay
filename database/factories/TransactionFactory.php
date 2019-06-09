<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Transaction;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'payee_id' => $faker->randomNumber(),
        'payer_id' => $faker->randomNumber(),
        'value' => $faker->randomFloat(),
    ];
});
