<?php

use Medlib\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
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

            User::create([
                'email' => $faker->unique()->email,
                'username' => $faker->unique()->username,
                'password' => bcrypt('secret1983'),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'profession' => $faker->randomElement(['student','researcher', 'teacher']),
                'location' => "",
                'date_of_birth' => $faker->date,
                'gender' => $faker->randomElement(['man','woman']),
                'activated' => true,
                'account_type' => false,
                'user_avatar' => $faker->imageUrl($width = 180, $height = 180)
            ]);
        }
    }
}
