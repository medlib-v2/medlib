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

$factory->define(Medlib\Models\User::class, function (Faker\Generator $faker) {
    return [

        'email' => $faker->unique()->email,
        'username' => $faker->unique()->username,
        'password' => Hash::make(str_random(10)),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'profession' => $faker->randomElement(['student','researcher', 'teacher']),
        'location' => "",
        'date_of_birth' => $faker->date,
        'gender' => $faker->randomElement(['man','woman']),
        'user_active' => true,
        'account_type' => false,
        'user_avatar' => $faker->imageUrl($width = 180, $height = 180),
        'remember_token' => str_random(10),
        'confirmation_code' => UserTableSeeder::generateToken()
    ];
});

$factory->define(Medlib\Models\Message::class, function (Faker\Generator $faker) {

    $userIds = DB::table('users')->where('id', '!=', 1)->lists('id');

    return [
        'body'		=> $faker->sentence(),
        'senderprofileimage' => $faker->imageUrl($width = 180, $height = 180),
        'senderid' => $faker->randomElement($userIds),
        'sendername' => $faker->firstName,
    ];
});