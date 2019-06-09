<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Consumer;
use App\Account;

$factory->define(Consumer::class, function (Faker $faker) {
    return [
        'account_id' => factory(Account::class)->create()->id,
    ];
});
