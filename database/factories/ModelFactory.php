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
        'password' => bcrypt(str_random(10)),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'profession' => $faker->randomElement(['student','researcher', 'teacher']),
        'location' => "",
        'date_of_birth' => $faker->date,
        'gender' => $faker->randomElement(['man','woman']),
        'activated' => true,
        'account_type' => false,
        'user_avatar' => $faker->imageUrl($width = 180, $height = 180),
        'remember_token' => str_random(10),
        'confirmation_code' => UserTableSeeder::generateToken()
    ];
});

$factory->define(Medlib\Models\Message::class, function (Faker\Generator $faker) {
    $userIds = DB::table('users')->where('id', '!=', 1)->lists('id');

    return [
        'body'        => $faker->sentence(),
        'sender_profile_image' => $faker->imageUrl($width = 200, $height = 200),
        'sender_id' => $faker->randomElement($userIds),
        'sender_name' => $faker->firstName,
    ];
});

$factory->define(Medlib\Models\Profile::class, function (Faker\Generator $faker) {
    return [
        'location' => $faker->city,
        'about' => $faker->paragraph(4)
    ];
});