<?php

use Medlib\Models\Hashtag;
use Illuminate\Database\Seeder;

class HashtagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Hashtag::class, 30)->create();
    }
}
