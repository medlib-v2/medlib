<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Medlib\Models\MessageResponse;

class MessageResponsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $messageIds = DB::table('messages')->pluck('id');

        $messageSenderIds = DB::table('messages')->pluck('sender_id');


        foreach ($messageIds as $messageId) {
            MessageResponse::create([
                'body'        => $faker->sentence,
                'message_id' => $messageId,
                'sender_id' => $faker->randomElement($messageSenderIds),
                'receiver_id' => 1,
                'sender_name' => $faker->name,
                'sender_profile_image' => $faker->imageUrl($width = 180, $height = 180)
            ]);
        }
    }
}
