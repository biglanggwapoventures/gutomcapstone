<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'firstname' => $faker->firstName, 
        'lastname' => $faker->lastName,
        'username' => $faker->username,
        'password' => bcrypt('secret'), 
        'email' => $faker->unique()->safeEmail, 
        'contact_number' => $faker->e164PhoneNumber,
        'role' => App\User::ROLE_USER
    ];
});