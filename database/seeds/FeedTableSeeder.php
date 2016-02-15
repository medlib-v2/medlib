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
        $users = User::lists('id');
        $date = new DateTime();
        $day = 1;
        //$users = [10,12,13,14,15];

        foreach ($users as $user) {

            foreach (range(1, 30) as $index) {

                $day++;

                $date->setDate(2015, 1, $day);

                Feed::create([
                    'user_id'	=> $user,
                    'body'		=> $faker->sentence(),
                    'poster_firstname' => $faker->firstName,
                    'poster_profile_image' => $faker->imageUrl($width = 180, $height = 180),
                    'created_at'=> $date->format('Y-m-d H:i:s'),
                    'updated_at'=> $date->format('Y-m-d H:i:s')
                ]);
            }

        }
    }
}
