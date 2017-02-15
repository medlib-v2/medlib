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

    $email = $faker->unique()->email;

    return [
        'email' => $email,
        'username' => $faker->unique()->username,
        'password' => bcrypt("secret1983"),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'profession' => $faker->randomElement(['student','researcher', 'teacher']),
        'date_of_birth' => $faker->date,
        'gender' => $faker->randomElement(['man','woman']),
        'activated' => true,
        'account_type' => false,
        'user_avatar' => "https://www.gravatar.com/avatar/".md5(strtolower($email))."?d=identicon",
        'remember_token' => str_random(32)
    ];
});

$factory->define(Medlib\Models\Message::class, function (Faker\Generator $faker) {
    $userIds = DB::table('users')->where('id', '!=', 1)->lists('id');

    return [
        'body'  => $faker->sentence(),
        'sender_id' => $faker->randomElement($userIds),
        'receiver_id' => $faker->randomElement($userIds),
    ];
});

$factory->define(Medlib\Models\Profile::class, function (Faker\Generator $faker) {
    return [
        'location' => $faker->city,
        'about' => $faker->paragraph(4)
    ];
});