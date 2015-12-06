<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publishers')->insert([
            ['name' => 'Waremme', 'place' => 'Rue Rewe 13, 4300 Waremme, Belgique'],
            ['name' => 'Chiroux', 'place' => 'Rue des Croisiers 15, 4000 Liège, Belgique'],
            ['name' => 'Vervier', 'place' => '4800 Verviers, Belgique'],
            ['name' => 'Bruxelles', 'place' => 'Rue Haute 247, 1000 Ville de Bruxelles, Belgique'],
            ['name' => 'Huy', 'place' => 'Rue des Augustins 18/b, 4500 Huy, Belgique'],
            ['name' => 'Bastogne', 'place' => 'Rue Gustave Delperdange 5B, 3620 Bastogne, Belgique']
        ]);
    }
}
