<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'description' => 'Administrador',
        ]);

        DB::table('roles')->insert([
            'name' => 'gerente',
            'description' => 'Gerente',
        ]);

        DB::table('roles')->insert([
            'name' => 'operador1',
            'description' => 'Operador Nível 1',
        ]);

        DB::table('roles')->insert([
            'name' => 'operador2',
            'description' => 'Operador Nível 2',
        ]);

        DB::table('roles')->insert([
            'name' => 'leitor',
            'description' => 'Leitor',
        ]);
    }
}
