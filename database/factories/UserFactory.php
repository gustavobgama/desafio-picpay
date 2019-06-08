<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'cpf' => $faker->cpf(false),
        'email' => $faker->unique()->safeEmail,
        'full_name' => $faker->name,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'phone_number' => $faker->phoneNumber,
    ];
});
