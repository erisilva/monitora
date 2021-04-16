<?php

use Illuminate\Database\Seeder;

class ComorbidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comorbidades')->insert(['id' => 1, 'descricao' => 'Diabetes']);
        DB::table('comorbidades')->insert(['id' => 2, 'descricao' => 'Doenças Respiratórias']);
        DB::table('comorbidades')->insert(['id' => 3, 'descricao' => 'Doenças Cardiovasculares']);
        DB::table('comorbidades')->insert(['id' => 4, 'descricao' => 'Hipertensão']);
        DB::table('comorbidades')->insert(['id' => 5, 'descricao' => 'Nenhuma']);
    }
}
