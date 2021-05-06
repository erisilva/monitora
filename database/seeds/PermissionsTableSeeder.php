<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	// permissões possíveis para o cadastro de operadores do sistema
    	// user = operador
        DB::table('permissions')->insert([
            'name' => 'user-index',
            'description' => 'Lista de operadores',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-create',
            'description' => 'Registrar novo operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-edit',
            'description' => 'Alterar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-delete',
            'description' => 'Excluir operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-show',
            'description' => 'Mostrar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-export',
            'description' => 'Exportação de dados dos operadores',
        ]);


		// permissões possíveis para o cadastro de perfis do sistema
        //role = perfil
        DB::table('permissions')->insert([
            'name' => 'role-index',
            'description' => 'Lista de perfis',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-create',
            'description' => 'Registrar novo perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-edit',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-delete',
            'description' => 'Excluir perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-show',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-export',
            'description' => 'Exportação de dados dos perfis',
        ]);

        // permissões possíveis para o cadastro de permissões do sistema
        //permission = permissão de acesso
        DB::table('permissions')->insert([
            'name' => 'permission-index',
            'description' => 'Lista de permissões',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-create',
            'description' => 'Registrar nova permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-edit',
            'description' => 'Alterar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-delete',
            'description' => 'Excluir permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-show',
            'description' => 'Mostrar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-export',
            'description' => 'Exportação de dados das permissões',
        ]);

        //distritos
        DB::table('permissions')->insert([
            'name' => 'distrito-index',
            'description' => 'Lista de distritos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito-create',
            'description' => 'Registrar novo distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito-edit',
            'description' => 'Alterar dados do distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito-delete',
            'description' => 'Excluir distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito-show',
            'description' => 'Mostrar dados do distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito-export',
            'description' => 'Exportação de dados dos distritos',
        ]);

        //unidades
        DB::table('permissions')->insert([
            'name' => 'unidade-index',
            'description' => 'Lista de unidades',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade-create',
            'description' => 'Registrar nova unidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade-edit',
            'description' => 'Alterar dados de uma unidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade-delete',
            'description' => 'Excluir unidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade-show',
            'description' => 'Mostrar dados das unidades',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade-export',
            'description' => 'Exportação de dados das unidades',
        ]);


        //sintomas
        DB::table('permissions')->insert([
            'name' => 'sintoma-index',
            'description' => 'Lista de sintomas',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma-create',
            'description' => 'Registrar novo sintoma',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma-edit',
            'description' => 'Alterar dados do sintoma',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma-delete',
            'description' => 'Excluir sintoma',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma-show',
            'description' => 'Mostrar dados do sintoma',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma-export',
            'description' => 'Exportação de dados dos sintomas',
        ]);

        //sintomas do cadastro
        DB::table('permissions')->insert([
            'name' => 'sintoma_cadastro-index',
            'description' => 'Lista de sintomas',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma_cadastro-create',
            'description' => 'Registrar novo sintoma do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma_cadastro-edit',
            'description' => 'Alterar dados do sintoma do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma_cadastro-delete',
            'description' => 'Excluir sintoma do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma_cadastro-show',
            'description' => 'Mostrar dados do sintoma do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'sintoma_cadastro-export',
            'description' => 'Exportação de dados dos sintomas do cadastro',
        ]);

        //doenças base
        DB::table('permissions')->insert([
            'name' => 'doencasbase-index',
            'description' => 'Lista de doenças de base',
        ]);
        DB::table('permissions')->insert([
            'name' => 'doencasbase-create',
            'description' => 'Registrar novo doença de base do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'doencasbase-edit',
            'description' => 'Alterar dados do doença de base do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'doencasbase-delete',
            'description' => 'Excluir doença de base do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'doencasbase-show',
            'description' => 'Mostrar dados do doença de base do cadastro',
        ]);
        DB::table('permissions')->insert([
            'name' => 'doencasbase-export',
            'description' => 'Exportação de dados des doenças de base do cadastro',
        ]);

        //comorbidades
        DB::table('permissions')->insert([
            'name' => 'comorbidade-index',
            'description' => 'Lista de comorbidades',
        ]);
        DB::table('permissions')->insert([
            'name' => 'comorbidade-create',
            'description' => 'Registrar novo comorbidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'comorbidade-edit',
            'description' => 'Alterar dados do comorbidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'comorbidade-delete',
            'description' => 'Excluir comorbidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'comorbidade-show',
            'description' => 'Mostrar dados do comorbidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'comorbidade-export',
            'description' => 'Exportação de dados dos comorbidades',
        ]);


        // Pacientes
        DB::table('permissions')->insert([
            'name' => 'paciente-index',
            'description' => 'Lista de pacientes',
        ]);
        DB::table('permissions')->insert([
            'name' => 'paciente-create',
            'description' => 'Registrar novo paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'paciente-edit',
            'description' => 'Alterar dados do paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'paciente-delete',
            'description' => 'Excluir paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'paciente-show',
            'description' => 'Mostrar dados do paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'paciente-export',
            'description' => 'Exportação de dados dos pacientes',
        ]);


        // Pacientes
        DB::table('permissions')->insert([
            'name' => 'monitoramento-index',
            'description' => 'Lista de monitoramentos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'monitoramento-create',
            'description' => 'Registrar novo monitoramento',
        ]);
        DB::table('permissions')->insert([
            'name' => 'monitoramento-edit',
            'description' => 'Alterar dados do monitoramento',
        ]);
        DB::table('permissions')->insert([
            'name' => 'monitoramento-delete',
            'description' => 'Excluir monitoramento',
        ]);
        DB::table('permissions')->insert([
            'name' => 'monitoramento-show',
            'description' => 'Mostrar dados do monitoramento',
        ]);
        DB::table('permissions')->insert([
            'name' => 'monitoramento-export',
            'description' => 'Exportação de dados dos monitoramentos',
        ]);       
    }
}
