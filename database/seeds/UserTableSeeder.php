<?php

use Medlib\Models\User;
use Medlib\Models\Profile;
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
        factory(User::class, 30)->create()->each(
            function($user) {
                $user->profile()->save(
                    factory(Profile::class)->make()
                );
            }
        );
    }
}
