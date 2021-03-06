<?php

use Medlib\Models\Message;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $userIds = DB::table('users')->where('id', '!=', 1)->lists('id');

        foreach (range(1, 25) as $index) {

            Message::create([
                'body'		=> $faker->sentence(),
                'senderprofileimage' => $faker->imageUrl($width = 180, $height = 180),
                'senderid' => $faker->randomElement($userIds),
                'sendername' => $faker->firstName
            ]);
        }
    }
}
