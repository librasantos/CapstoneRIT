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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Message::class, function(Faker\Generator $faker){
    return [
      'message' => $faker->paragraph,
    ];
});

//$factory->define(App\Group::class, function(Faker\Generator $faker){
//    $departments = ['Accounting', 'IT', 'HumanResources', 'Security'];
//    return [
//        'name' => $departments[rand(0, 3)],
//    ];
//});

$factory->define(App\Config::class, function(Faker\Generator $faker){
    return [
      'key' => $faker->word,
      'value' => $faker->word
    ];
});
