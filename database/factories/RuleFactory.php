<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Rule::class, function (Faker $faker) {
    return config('rule');
});

