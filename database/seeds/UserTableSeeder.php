<?php

use Medlib\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->truncate();

        $faker = Faker::create();


        foreach (range(1, 30) as $index) {

            User::create([
                'email' => $faker->unique()->email,
                'username' => $faker->unique()->username,
                'password' => Hash::make('secret1983'),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'profession' => $faker->randomElement(['student','researcher', 'teacher']),
                'location' => "",
                'date_of_birth' => $faker->date,
                'gender' => $faker->randomElement(['man','woman']),
                'user_active' => true,
                'account_type' => false,
                'user_avatar' => $faker->imageUrl($width = 180, $height = 180),
                'confirmation_code' => self::generateToken()
            ]);
        }
    }


    /**
     * Generate the verification token.
     *
     * @return string
     */
    public static function generateToken() {

        return str_random(64).config('app.key');
    }
}
