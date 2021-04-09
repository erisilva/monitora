<?php

use Illuminate\Database\Seeder;

class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('unidades')->insert(['id' => 6, 'descricao' => 'Perobas', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 7, 'descricao' => 'Bela Vista', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 8, 'descricao' => 'Sandoval Azevedo', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 9, 'descricao' => 'Presidente Vargas', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 10, 'descricao' => 'Barraginha', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 11, 'descricao' => 'Vila Diniz', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 12, 'descricao' => 'Estâncias Imperiais', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 13, 'descricao' => 'Petrolandia', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 14, 'descricao' => 'Duque de Caxias', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 15, 'descricao' => 'Sao Luiz I', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 16, 'descricao' => 'Sao Luiz II', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 17, 'descricao' => 'Tropical II', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 18, 'descricao' => 'Campina Verde', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 19, 'descricao' => 'Novo Boa Vista', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 20, 'descricao' => 'Novo Progresso I', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 21, 'descricao' => 'Novo Progresso II', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 22, 'descricao' => 'Monte Castelo', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 23, 'descricao' => 'Durval De Barros', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 24, 'descricao' => 'Linda Vista', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 25, 'descricao' => 'Alvorada', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 26, 'descricao' => 'Funcionários', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 27, 'descricao' => 'Canada', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 28, 'descricao' => 'Chacaras', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 29, 'descricao' => 'Vila Italia', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 30, 'descricao' => 'Estaleiro', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 31, 'descricao' => 'Ipe Amarelo', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 32, 'descricao' => 'Nova Contagem I', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 33, 'descricao' => 'Nova Contagem II', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 34, 'descricao' => 'Vila Renascer', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 35, 'descricao' => 'Vila Esperança', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 36, 'descricao' => 'Jardim Eldorado', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 37, 'descricao' => 'Parque Sao João', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 38, 'descricao' => 'Agua Branca', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 39, 'descricao' => 'Eldorado', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 40, 'descricao' => 'Jardim Bandeirantes', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 41, 'descricao' => 'Unidade XV', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 42, 'descricao' => 'Novo Eldorado', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 43, 'descricao' => 'João Evangelista', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 44, 'descricao' => 'Bandeirantes', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 45, 'descricao' => 'Vila Sao Paulo', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 46, 'descricao' => 'Amazonas I', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 47, 'descricao' => 'Amazonas', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 48, 'descricao' => 'Jardim Industrial', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 49, 'descricao' => 'Industrial III Seçao', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 50, 'descricao' => 'Joaquim Murtinho', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 51, 'descricao' => 'Estrela Dalva', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 52, 'descricao' => 'Ilda Efigenia', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 53, 'descricao' => 'Nacional', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 54, 'descricao' => 'Amendoeiras', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 55, 'descricao' => 'Xangrila', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 56, 'descricao' => 'Tijuca', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 57, 'descricao' => 'Campo Alto', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 58, 'descricao' => 'Sapucaias', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 59, 'descricao' => 'Laguna', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 60, 'descricao' => 'Colorado', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 61, 'descricao' => 'Oitis', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 62, 'descricao' => 'Parque Turista', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 63, 'descricao' => 'Sao Joaquim', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 64, 'descricao' => 'Arpoador', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 65, 'descricao' => 'Vila Perola', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 66, 'descricao' => 'Presidente Kennedy', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 67, 'descricao' => 'Riacho', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 68, 'descricao' => 'Novo Riacho', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 69, 'descricao' => 'Flamengo', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 70, 'descricao' => 'Sesc', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 71, 'descricao' => 'Centro', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 72, 'descricao' => 'Maria da Conceiçao', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 73, 'descricao' => 'Praia', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 74, 'descricao' => 'Bernardo Monteiro', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 75, 'descricao' => 'Santa Helena', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 76, 'descricao' => 'Icaivera', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 77, 'descricao' => 'Retiro', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 78, 'descricao' => 'Sao Judas Tadeu', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 79, 'descricao' => 'Vila Soledade', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 80, 'descricao' => 'Darcy Ribeiro', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 81, 'descricao' => 'Morada Nova', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 82, 'descricao' => 'Unidade De Referencia Saude Da Familia Vargem Das Flores', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 83, 'descricao' => 'Unidade De Referencia Saude Da Familia Vargem Petrolandia', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 84, 'descricao' => 'Distrito Sanitario Eldorado', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 85, 'descricao' => 'FARMACIA DISTRITAL AGUA BRANCA', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 86, 'descricao' => 'FARMACIA DISTRITAL DO ELDORADO I', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 87, 'descricao' => 'FARMACIA DISTRITAL ELDORADO II', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 88, 'descricao' => 'FARMACIA DISTRITAL PARQUE SAO JOAO', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 89, 'descricao' => 'FARMACIA DISTRITAL VARGEM DAS FLORES I', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 90, 'descricao' => 'FARMACIA DISTRITAL VARGEM DAS FLORES II', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 91, 'descricao' => 'FARMACIA DISTRITAL VARGEM DAS FLORES III', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 92, 'descricao' => 'Distrito Sanitário Vargem Das Flores', 'distrito_id' => 7]);
		DB::table('unidades')->insert(['id' => 93, 'descricao' => 'FARMACIA DISTRITAL PETROLANDIA I', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 94, 'descricao' => 'Distrito Sanitario Petrolandia', 'distrito_id' => 4]);
		DB::table('unidades')->insert(['id' => 95, 'descricao' => 'FARMACIA DISTRITAL DO RIACHO', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 96, 'descricao' => 'Distrito Sanitario Riacho', 'distrito_id' => 8]);
		DB::table('unidades')->insert(['id' => 97, 'descricao' => 'Distrito Sanitario Industrial', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 98, 'descricao' => 'FARMACIA DISTRITAL INDUSTRIAL', 'distrito_id' => 2]);
		DB::table('unidades')->insert(['id' => 99, 'descricao' => 'Distrito Sanitario Sede', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 100, 'descricao' => 'FARMACIA DISTRITAL SANTA HELENA', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 101, 'descricao' => 'FARMACIA DISTRITAL SEDE', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 102, 'descricao' => 'Distrito Sanitario Ressaca', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 103, 'descricao' => 'FARMACIA DISTRITAL RESSACA I', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 104, 'descricao' => 'FARMACIA DISTRITAL RESSACA II', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 105, 'descricao' => 'FARMACIA DISTRITAL NACIONAL I', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 106, 'descricao' => 'FARMACIA DISTRITAL NACIONAL II', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 107, 'descricao' => 'Distrito Sanitario Nacional', 'distrito_id' => 3]);
		DB::table('unidades')->insert(['id' => 108, 'descricao' => 'CENTRO DE ATENCAO PSICOSSOCIAL INFANTO-JUVENIL - CAPS I', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 109, 'descricao' => 'CAPS III ELDORADO', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 110, 'descricao' => 'CENTRO DE ATENCAO PSICOSSOCIAL ALCOOL E DROGAS - CAPS AD', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 111, 'descricao' => 'CENTRO DE ATENCAO PSICOSSOCIAL - CAPS III - SEDE', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 112, 'descricao' => 'CENTRO DE CONVIVENCIA HORIZONTE ABERTO', 'distrito_id' => 1]);
		DB::table('unidades')->insert(['id' => 113, 'descricao' => 'Unidade De Referencia Da Saude da Familia Ressaca', 'distrito_id' => 5]);
		DB::table('unidades')->insert(['id' => 114, 'descricao' => 'CEO - CENTRO DE ESPECIALIDADES ODONTOLOGICAS', 'distrito_id' => 6]);
		DB::table('unidades')->insert(['id' => 115, 'descricao' => 'Nascentes Imperais', 'distrito_id' => 4]);


    }
}
