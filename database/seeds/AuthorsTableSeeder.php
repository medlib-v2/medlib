<?php

use Medlib\Models\Author;
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
        Author::create([
            'frist_name' => 'Pierre',
            'last_name' => 'Rabhi'
        ]);

        Author::create([
            'frist_name' => 'J.K.',
            'last_name' => 'Rowling'
        ]);

        Author::create([
            'frist_name' => 'George',
            'last_name' => 'Simenon'
        ]);

        Author::create([
            'frist_name' => 'Eric-Emmanuel',
            'last_name' => 'Schmitt'
        ]);

        Author::create([
            'frist_name' => 'Philippe',
            'last_name' => 'Geluck'
        ]);

        Author::create([
            'frist_name' => 'Amélie',
            'last_name' => 'Nothomb'
        ]);
    }
}
