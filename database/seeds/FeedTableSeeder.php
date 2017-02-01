<?php

use Medlib\Models\Feed;
use Medlib\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class FeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::pluck('id');

        $date = new DateTime();
        $day = 1;

        foreach ($users as $user) {
            foreach (range(1, 30) as $index) {
                $day++;
            
                $date->setDate(2015, 1, $day);

                Feed::create([
                    'user_id'    => $user,
                    'body'        => $faker->sentence(),
                    'poster_username' => $faker->userName,
                    'poster_profile_image' => $faker->imageUrl($width = 180, $height = 180),
                    'image_url' => $faker->imageUrl($width = 600, $height = 280),
                    'video_url' => null,
                    'location' => $faker->latitude.",".$faker->longitude,
                    'created_at'=> $date->format('Y-m-d H:i:s'),
                    'updated_at'=> $date->format('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
