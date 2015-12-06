<?php

use Medlib\Models\Edition;
use Illuminate\Database\Seeder;

class EditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Edition::insert(['name' => 'Folio']);
        Edition::insert(['name' => 'Le livre de poche']);
        Edition::insert(['name' => 'Gallimard']);
        Edition::insert(['name' => 'L\'aube']);
        Edition::insert(['name' => 'Casterman']);
    }
}
