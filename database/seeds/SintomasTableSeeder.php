<?php

use Illuminate\Database\Seeder;

class SintomasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sintomas')->insert(['id' => 1, 'descricao' => 'Febre']);
        DB::table('sintomas')->insert(['id' => 2, 'descricao' => 'Tosse']);
        DB::table('sintomas')->insert(['id' => 3, 'descricao' => 'Dor de Garganta']);
        DB::table('sintomas')->insert(['id' => 4, 'descricao' => 'Coriza']);
        DB::table('sintomas')->insert(['id' => 5, 'descricao' => 'Dificuldade Respiratória']);
        DB::table('sintomas')->insert(['id' => 6, 'descricao' => 'Obstrução Nasal']);
    }
}
