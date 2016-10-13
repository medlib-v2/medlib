<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['category_name' => 'Philosophie naturaliste'],
            ['category_name' => 'Aventure'],
            ['category_name' => 'Fantastique'],
            ['category_name' => 'Policier'],
            ['category_name' => 'Théorie politique'],
            ['category_name' => 'Roman'],
            ['category_name' => 'Bande dessinée'],
            ['category_name' => 'Dramatique']
        ]);
    }
}
