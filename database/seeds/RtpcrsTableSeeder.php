<?php

use Illuminate\Database\Seeder;

class RtpcrsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // esse campo que vai estar ligado ao cadastro do paciente deverá ser selecionado automaticamente
        // pelo sistema de acordo com a opção passada no monitoramento
        DB::table('rtpcrs')->insert(['id' => 1, 'descricao' => 'Não Monitorado']);
        DB::table('rtpcrs')->insert(['id' => 2, 'descricao' => 'Não Atendeu']);
        DB::table('rtpcrs')->insert(['id' => 3, 'descricao' => 'Não Coletou']);
        DB::table('rtpcrs')->insert(['id' => 4, 'descricao' => 'Aguardando Resultado']);
        DB::table('rtpcrs')->insert(['id' => 5, 'descricao' => 'Positivo']);
        DB::table('rtpcrs')->insert(['id' => 6, 'descricao' => 'Negativo']);
    }
}
