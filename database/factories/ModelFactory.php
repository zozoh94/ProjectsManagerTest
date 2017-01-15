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
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Employee::class, function (Faker\Generator $faker) {    
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail       
    ];
});


$factory->define(App\Project::class, function (Faker\Generator $faker) {
    $startDate = $faker->dateTimeBetween('now', '+6 years');
    $date = clone $startDate;
    $date = $date->add(\DateInterval::createFromDateString('+6 years'));
    $endDate = $faker->dateTimeBetween($startDate, $date);
    return [
        'name' => $faker->sentence(3),
        'clientCompanyName' => $faker->sentence(2),
        'performerCompanyName' => $faker->sentence(2),
        'startDate' => $startDate,
        'endDate' => $endDate,
        'priority' => $faker->numberBetween(0, 100),
        'leader_id' => function () {
            return App\Employee::inRandomOrder()->first()->id;
        },
        'comment' => $faker->text()
    ];
});