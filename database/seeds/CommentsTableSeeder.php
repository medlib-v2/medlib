<?php

use Faker\Factory;
use Medlib\Models\Feed;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $posts = Feed::all();

        foreach ($posts as $post) {
            $comments = [
                'feed_id'   => $post->id,
                'comment'   => $faker->text,
                'user_id'   => $faker->numberBetween($min = 1, $max = 38), ];

            DB::table('comments')->insert($comments);
        }

        $comments = DB::table('comments')->select('id')->get();
        foreach ($comments as $comment) {
            $likes = [
                'user_id'    => $faker->numberBetween($min = 1, $max = 38),
                'comment_id' => $faker->numberBetween($min = 1, $max = 60), ];

            DB::table('comment_likes')->insert($likes);
        }
    }
}
