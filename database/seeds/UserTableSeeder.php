<?php

use Medlib\Models\User;
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
        DB::table('users')->truncate();

        User::create(array(
            'email'    => 'medlib-team@medlib-v2.lan',
            'username' => 'medlib',
            'password' => Hash::make('madlib-admin'),
            'first_name'     => 'Medlib',
            'last_name' => 'Team',
            'profession' => 'student',
            'date_of_birth' => '1985-08-05',
            'gender' => 'man',
            'user_active' => false,
            'account_type' => false,
            'user_avatar' => 'medlib-profile.jpg'

        ));

        User::create(array(
            'email'    => 'eldorplus@gmail.com',
            'username' => 'eldorplus',
            'password' => Hash::make('Lusquain01'),
            'first_name'     => 'Patrick',
            'last_name' => 'LUZOLO SIASIA',
            'profession' => 'student',
            'date_of_birth' => '1985-08-05',
            'gender' => 'man',
            'user_active' => true,
            'account_type' => false,
            'user_avatar' => 'eldorplus-profile.jpg'

        ));
    }
}
