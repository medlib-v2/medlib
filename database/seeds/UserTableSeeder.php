<?php

use Medlib\Models\User;
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
        factory(Medlib\Models\User::class, 30)->create()->each(
            function($user) {
                $user->profile()->save(
                    factory(Medlib\Models\Profile::class, 1)->make()
                );
            }
        );
    }
}
