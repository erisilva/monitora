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
        DB::table('doencas_bases')->insert(['id' => 1, 'descricao' => 'Doença Base Teste 1']);
        DB::table('doencas_bases')->insert(['id' => 2, 'descricao' => 'Doença Base Teste 2']);
        DB::table('doencas_bases')->insert(['id' => 3, 'descricao' => 'Doença Base Teste 3']);
        DB::table('doencas_bases')->insert(['id' => 4, 'descricao' => 'Doença Base Teste 4']);
        DB::table('doencas_bases')->insert(['id' => 5, 'descricao' => 'Doença Base Teste 5']);
    }
}
