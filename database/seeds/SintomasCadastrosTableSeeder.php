<?php

use Illuminate\Database\Seeder;

class SintomasCadastrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sintomas_cadastros')->insert(['id' => 1, 'nome' => 'Febre']);
        DB::table('sintomas_cadastros')->insert(['id' => 2, 'nome' => 'Tosse']);
        DB::table('sintomas_cadastros')->insert(['id' => 3, 'nome' => 'Dor de Garganta']);
        DB::table('sintomas_cadastros')->insert(['id' => 4, 'nome' => 'Coriza']);
        DB::table('sintomas_cadastros')->insert(['id' => 5, 'nome' => 'Dificuldade Respiratória']);
        DB::table('sintomas_cadastros')->insert(['id' => 5, 'nome' => 'Obstrução Nasal']);
    }
}
