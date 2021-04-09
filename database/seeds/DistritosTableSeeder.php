<?php

use Illuminate\Database\Seeder;

class DistritosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('distritos')->insert(['id' => 1, 'nome' => 'Eldorado']);
		DB::table('distritos')->insert(['id' => 2, 'nome' => 'Industrial']);
		DB::table('distritos')->insert(['id' => 3, 'nome' => 'Nacional']);
		DB::table('distritos')->insert(['id' => 4, 'nome' => 'Petrolândia']);
		DB::table('distritos')->insert(['id' => 5, 'nome' => 'Ressaca']);
		DB::table('distritos')->insert(['id' => 6, 'nome' => 'Sede']);
		DB::table('distritos')->insert(['id' => 7, 'nome' => 'Vargem das Flores']);
		DB::table('distritos')->insert(['id' => 8, 'nome' => 'Riacho']);
    }

}
