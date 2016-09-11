<?php

use Medlib\Models\Author;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        foreach (range(1, 30) as $index) {

            Author::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'biography' => $faker->text
            ]);
        }
    }
}
