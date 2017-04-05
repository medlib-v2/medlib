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

$factory->define(Medlib\Models\Timeline::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'name'     => $faker->name,
        // 'avatar_id' => $faker->numberBetween($min = 1, $max = 80),
        // 'cover_id' => $faker->numberBetween($min = 1, $max = 80)
    ];
});

$factory->define(Medlib\Models\User::class, function (Faker\Generator $faker) {

    $email = $faker->unique()->email;
    static $password;

    $timelineIds = DB::table('timelines')->where('id', '!=', 1)->pluck('id')->toArray();

    return [
        'timeline_id' => $faker->randomElement($timelineIds),
        'email' => $email,
        'username' => $faker->unique()->username,
        'password' => $password ?: $password = bcrypt("secret1983"),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'profession' => $faker->randomElement(['student','researcher', 'teacher']),
        'date_of_birth' => $faker->date,
        'gender' => $faker->randomElement(['male','female']),
        'activated' => true,
        'account_type' => false,
        'remember_token' => str_random(32)
    ];
});

$factory->define(Medlib\Models\Conversation::class, function (Faker\Generator $faker) {
    $userIds = DB::table('users')->where('id', '!=', 1)->pluck('id')->toArray();

    return [
        'sender_id' => $faker->randomElement($userIds),
        'receiver_id' => $faker->randomElement($userIds)
    ];
});

$factory->define(Medlib\Models\Message::class, function (Faker\Generator $faker) {
    $userIds = DB::table('users')->where('id', '!=', 1)->pluck('id')->toArray();
    $conversationsIds = DB::table('conversations')->where('id', '!=', 1)->pluck('id')->toArray();

    return [
        'body'  => $faker->sentence(),
        'sender_id' => $faker->randomElement($userIds),
        'receiver_id' => $faker->randomElement($userIds),
        'conversation_id' => $faker->randomElement($conversationsIds)
    ];
});

$factory->define(Medlib\Models\Profile::class, function (Faker\Generator $faker) {
    return [
        'location' => $faker->city,
        'country' => $faker->country,
        'timezone' => $faker->timezone,
        'about' => $faker->paragraph
    ];
});

$factory->define(Medlib\Models\Media::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->name,
        'type'   => 'image',
        'source' => $faker->randomElement($array = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '11.jpg', '12.jpg', '13.jpg', '1.png', '2.png', '3.png', '4.png']),
    ];
});

$factory->define(Medlib\Models\Hashtag::class, function (Faker\Generator $faker) {
    return [
        'tag'             => $faker->word,
        'last_trend_time' => $faker->dateTime($max = 'now'),
        'count'           => $faker->numberBetween($min = 3, $max = 60),
    ];
});

$factory->define(Medlib\Models\Announcement::class, function (Faker\Generator $faker) {
    return [
        'title'       => $faker->name,
        'description' => $faker->text,
        // 'image' => $faker->randomElement($array = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '11.jpg', '12.jpg', '13.jpg', '1.png', '2.png', '3.png', '4.png')),
        'start_date' => $faker->dateTime($max = 'now'),
        'end_date'   => $faker->dateTime($max = 'now'),
    ];
});

$factory->define(Medlib\Models\Feed::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => $faker->numberBetween($min = 1, $max = 38),
        'timeline_id' => $faker->numberBetween($min = 1, $max = 90),
        'body'        => $faker->text,
        'location'    => $faker->country,
        'type'        => $faker->randomElement($array = ['text', 'photo', 'music', 'video', 'location']),

    ];
    /**
    [
        'poster_username' => $faker->userName,
        'poster_profile_image' => $faker->imageUrl($width = 180, $height = 180),
        'image_url' => $faker->imageUrl($width = 600, $height = 280),
        'video_url' => null,
        'location' => $faker->latitude.",".$faker->longitude,
        'created_at'=> $date->format('Y-m-d H:i:s'),
        'updated_at'=> $date->format('Y-m-d H:i:s')
    ]
    **/
});
