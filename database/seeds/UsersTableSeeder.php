<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'adm@mail.com',
            'active' => 'Y',
            'password' => Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Gerente',
            'email' => 'gerente@mail.com',
            'active' => 'Y',
            'password' => Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Operador 1',
            'email' => 'operador1@mail.com',
            'active' => 'Y',
            'password' => Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Operador 2',
            'email' => 'operador2@mail.com',
            'active' => 'Y',
            'password' => Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Leitor',
            'email' => 'leitor@mail.com',
            'active' => 'Y',
            'password' => Hash::make('123456'),
        ]);
    }
}
