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
        factory(Feed::class, 260)->create();

        $posts = Feed::all();


        foreach ($posts as $post) {
            $follows = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38'], $faker->numberBetween(1, 3));

            $post->follows()->sync($follows);
        }

        //Seeding post likes
        foreach ($posts as $post) {
            $likes = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38'], $faker->numberBetween(1, 3));

            $post->likes()->sync($likes);
        }

        //Seeding post media
        foreach ($posts as $post) {
            $media = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38'], $faker->numberBetween(1, 3));

            $post->images()->sync($media);
        }

        //Seeding post shares
        foreach ($posts as $post) {
            $shares = $faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38'], $faker->numberBetween(1, 3));

            $post->shared()->sync($shares);
        }

        /**
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
        **/
    }
}
