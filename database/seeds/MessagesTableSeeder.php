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

        $userIds = DB::table('users')->where('id', '!=', 1)->pluck('id')->toArray();

        foreach (range(1, 25) as $index) {
            Message::create([
                'body'        => $faker->sentence(),
                'sender_id' => $faker->randomElement($userIds),
                'receiver_id' => $faker->randomElement($userIds),
            ]);
        }
    }
}
