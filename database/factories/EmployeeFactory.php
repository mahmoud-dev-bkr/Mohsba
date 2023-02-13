<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;


$factory->define(Employee::class, function (Faker $faker) {
    return [
        //
        'name' => $this->faker->name(),
        'job_number' => rand(10000, 99999),
        'email' => $this->faker->unique()->safeEmail(),
        'phone' => random_int(10000000000, 99999999999),
        'branch_id' => 7,
        'job_id' => 4,
    ];
});
