<?php

use Illuminate\Database\Seeder;

class DoencasBasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doencas_bases')->insert(['id' => 1, 'nome' => 'Doença Base Teste 1']);
        DB::table('doencas_bases')->insert(['id' => 2, 'nome' => 'Doença Base Teste 2']);
        DB::table('doencas_bases')->insert(['id' => 3, 'nome' => 'Doença Base Teste 3']);
        DB::table('doencas_bases')->insert(['id' => 4, 'nome' => 'Doença Base Teste 4']);
        DB::table('doencas_bases')->insert(['id' => 5, 'nome' => 'Doença Base Teste 5']);
    }
}
