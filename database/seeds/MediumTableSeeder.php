<?php

use Medlib\Models\Media;
use Illuminate\Database\Seeder;

class MediumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Media::class, 80)->create();
    }
}
