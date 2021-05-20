<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
use App\Permission;

use Illuminate\Support\Facades\DB;

class acl extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apaga todas as tabelas de relacionamento
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();

        // recebe os operadores principais principais do sistema
        // utilizo o termo operador em vez de usuário por esse
        // significar usuário do SUS, ou usuário do plano, em vez de pessoa ou cliente
        $administrador = User::where('email','=','adm@mail.com')->get()->first();
        $gerente = User::where('email','=','gerente@mail.com')->get()->first();
        $operador1 = User::where('email','=','operador1@mail.com')->get()->first();
        $operador2 = User::where('email','=','operador2@mail.com')->get()->first();
        $leitor = User::where('email','=','leitor@mail.com')->get()->first();

        // recebi os perfis
        $administrador_perfil = Role::where('name', '=', 'admin')->get()->first();
        $gerente_perfil = Role::where('name', '=', 'gerente')->get()->first();
        $operador1_perfil = Role::where('name', '=', 'operador1')->get()->first();
        $operador2_perfil = Role::where('name', '=', 'operador2')->get()->first();
        $leitor_perfil = Role::where('name', '=', 'leitor')->get()->first();

        // salva os relacionamentos entre operador e perfil
        $administrador->roles()->attach($administrador_perfil);
        $gerente->roles()->attach($gerente_perfil);
        $operador1->roles()->attach($operador1_perfil);
        $operador2->roles()->attach($operador2_perfil);
        $leitor->roles()->attach($leitor_perfil);

        // recebi as permissoes
        // para operadores
		$user_index = Permission::where('name', '=', 'user-index')->get()->first();       
		$user_create = Permission::where('name', '=', 'user-create')->get()->first();      
		$user_edit = Permission::where('name', '=', 'user-edit')->get()->first();        
		$user_delete = Permission::where('name', '=', 'user-delete')->get()->first();      
		$user_show = Permission::where('name', '=', 'user-show')->get()->first();        
		$user_export = Permission::where('name', '=', 'user-export')->get()->first();      
		// para perfis
		$role_index = Permission::where('name', '=', 'role-index')->get()->first();       
		$role_create = Permission::where('name', '=', 'role-create')->get()->first();      
		$role_edit = Permission::where('name', '=', 'role-edit')->get()->first();        
		$role_delete = Permission::where('name', '=', 'role-delete')->get()->first();      
		$role_show = Permission::where('name', '=', 'role-show')->get()->first();        
		$role_export = Permission::where('name', '=', 'role-export')->get()->first();      
		// para permissões
		$permission_index = Permission::where('name', '=', 'permission-index')->get()->first(); 
		$permission_create = Permission::where('name', '=', 'permission-create')->get()->first();
		$permission_edit = Permission::where('name', '=', 'permission-edit')->get()->first();  
		$permission_delete = Permission::where('name', '=', 'permission-delete')->get()->first();
		$permission_show = Permission::where('name', '=', 'permission-show')->get()->first();  
		$permission_export = Permission::where('name', '=', 'permission-export')->get()->first();
		// para distritos
		$distrito_index = Permission::where('name', '=', 'distrito-index')->get()->first(); 
		$distrito_create = Permission::where('name', '=', 'distrito-create')->get()->first();
		$distrito_edit = Permission::where('name', '=', 'distrito-edit')->get()->first();  
		$distrito_delete = Permission::where('name', '=', 'distrito-delete')->get()->first();
		$distrito_show = Permission::where('name', '=', 'distrito-show')->get()->first();  
		$distrito_export = Permission::where('name', '=', 'distrito-export')->get()->first();
		// para unidades
		$unidade_index = Permission::where('name', '=', 'unidade-index')->get()->first(); 
		$unidade_create = Permission::where('name', '=', 'unidade-create')->get()->first();
		$unidade_edit = Permission::where('name', '=', 'unidade-edit')->get()->first();  
		$unidade_delete = Permission::where('name', '=', 'unidade-delete')->get()->first();
		$unidade_show = Permission::where('name', '=', 'unidade-show')->get()->first();  
		$unidade_export = Permission::where('name', '=', 'unidade-export')->get()->first();
		// para sintomas
		$sintoma_index = Permission::where('name', '=', 'sintoma-index')->get()->first(); 
		$sintoma_create = Permission::where('name', '=', 'sintoma-create')->get()->first();
		$sintoma_edit = Permission::where('name', '=', 'sintoma-edit')->get()->first();  
		$sintoma_delete = Permission::where('name', '=', 'sintoma-delete')->get()->first();
		$sintoma_show = Permission::where('name', '=', 'sintoma-show')->get()->first();  
		$sintoma_export = Permission::where('name', '=', 'sintoma-export')->get()->first();
		// para sintomas do cadastro ou iniciais
		$sintoma_cadastro_index = Permission::where('name', '=', 'sintoma_cadastro-index')->get()->first(); 
		$sintoma_cadastro_create = Permission::where('name', '=', 'sintoma_cadastro-create')->get()->first();
		$sintoma_cadastro_edit = Permission::where('name', '=', 'sintoma_cadastro-edit')->get()->first();  
		$sintoma_cadastro_delete = Permission::where('name', '=', 'sintoma_cadastro-delete')->get()->first();
		$sintoma_cadastro_show = Permission::where('name', '=', 'sintoma_cadastro-show')->get()->first();  
		$sintoma_cadastro_export = Permission::where('name', '=', 'sintoma_cadastro-export')->get()->first();
		// para doenças de base
		$doencasbase_index = Permission::where('name', '=', 'doencasbase-index')->get()->first(); 
		$doencasbase_create = Permission::where('name', '=', 'doencasbase-create')->get()->first();
		$doencasbase_edit = Permission::where('name', '=', 'doencasbase-edit')->get()->first();  
		$doencasbase_delete = Permission::where('name', '=', 'doencasbase-delete')->get()->first();
		$doencasbase_show = Permission::where('name', '=', 'doencasbase-show')->get()->first();  
		$doencasbase_export = Permission::where('name', '=', 'doencasbase-export')->get()->first();
		// para sintomas
		$comorbidade_index = Permission::where('name', '=', 'comorbidade-index')->get()->first(); 
		$comorbidade_create = Permission::where('name', '=', 'comorbidade-create')->get()->first();
		$comorbidade_edit = Permission::where('name', '=', 'comorbidade-edit')->get()->first();  
		$comorbidade_delete = Permission::where('name', '=', 'comorbidade-delete')->get()->first();
		$comorbidade_show = Permission::where('name', '=', 'comorbidade-show')->get()->first();  
		$comorbidade_export = Permission::where('name', '=', 'comorbidade-export')->get()->first();
		// para pacientes
		$paciente_index = Permission::where('name', '=', 'paciente-index')->get()->first(); 
		$paciente_create = Permission::where('name', '=', 'paciente-create')->get()->first();
		$paciente_edit = Permission::where('name', '=', 'paciente-edit')->get()->first();  
		$paciente_delete = Permission::where('name', '=', 'paciente-delete')->get()->first();
		$paciente_show = Permission::where('name', '=', 'paciente-show')->get()->first();  
		$paciente_export = Permission::where('name', '=', 'paciente-export')->get()->first();
		// para monitoramentos
		$monitoramento_index = Permission::where('name', '=', 'monitoramento-index')->get()->first(); 
		$monitoramento_create = Permission::where('name', '=', 'monitoramento-create')->get()->first();
		$monitoramento_edit = Permission::where('name', '=', 'monitoramento-edit')->get()->first();  
		$monitoramento_delete = Permission::where('name', '=', 'monitoramento-delete')->get()->first();
		$monitoramento_show = Permission::where('name', '=', 'monitoramento-show')->get()->first();  
		$monitoramento_export = Permission::where('name', '=', 'monitoramento-export')->get()->first();


		// salva os relacionamentos entre perfil e suas permissões
		
		// o administrador tem acesso total ao sistema, incluindo
		// configurações avançadas de desenvolvimento
		$administrador_perfil->permissions()->attach($user_index);
		$administrador_perfil->permissions()->attach($user_create);
		$administrador_perfil->permissions()->attach($user_edit);
		$administrador_perfil->permissions()->attach($user_delete);
		$administrador_perfil->permissions()->attach($user_show);
		$administrador_perfil->permissions()->attach($user_export);
		$administrador_perfil->permissions()->attach($role_index);
		$administrador_perfil->permissions()->attach($role_create);
		$administrador_perfil->permissions()->attach($role_edit);
		$administrador_perfil->permissions()->attach($role_delete);
		$administrador_perfil->permissions()->attach($role_show);
		$administrador_perfil->permissions()->attach($role_export);
		$administrador_perfil->permissions()->attach($permission_index);
		$administrador_perfil->permissions()->attach($permission_create);
		$administrador_perfil->permissions()->attach($permission_edit);
		$administrador_perfil->permissions()->attach($permission_delete);
		$administrador_perfil->permissions()->attach($permission_show);
		$administrador_perfil->permissions()->attach($permission_export);
		# distritos
		$administrador_perfil->permissions()->attach($distrito_index);
		$administrador_perfil->permissions()->attach($distrito_create);
		$administrador_perfil->permissions()->attach($distrito_edit);
		$administrador_perfil->permissions()->attach($distrito_delete);
		$administrador_perfil->permissions()->attach($distrito_show);
		$administrador_perfil->permissions()->attach($distrito_export);
		# unidades
		$administrador_perfil->permissions()->attach($unidade_index);
		$administrador_perfil->permissions()->attach($unidade_create);
		$administrador_perfil->permissions()->attach($unidade_edit);
		$administrador_perfil->permissions()->attach($unidade_delete);
		$administrador_perfil->permissions()->attach($unidade_show);
		$administrador_perfil->permissions()->attach($unidade_export);
		# sintomas
		$administrador_perfil->permissions()->attach($sintoma_index);
		$administrador_perfil->permissions()->attach($sintoma_create);
		$administrador_perfil->permissions()->attach($sintoma_edit);
		$administrador_perfil->permissions()->attach($sintoma_delete);
		$administrador_perfil->permissions()->attach($sintoma_show);
		$administrador_perfil->permissions()->attach($sintoma_export);
		# sintomas iniciais ou do cadastro
		$administrador_perfil->permissions()->attach($sintoma_cadastro_index);
		$administrador_perfil->permissions()->attach($sintoma_cadastro_create);
		$administrador_perfil->permissions()->attach($sintoma_cadastro_edit);
		$administrador_perfil->permissions()->attach($sintoma_cadastro_delete);
		$administrador_perfil->permissions()->attach($sintoma_cadastro_show);
		$administrador_perfil->permissions()->attach($sintoma_cadastro_export);
		# doenças de base
		$administrador_perfil->permissions()->attach($doencasbase_index);
		$administrador_perfil->permissions()->attach($doencasbase_create);
		$administrador_perfil->permissions()->attach($doencasbase_edit);
		$administrador_perfil->permissions()->attach($doencasbase_delete);
		$administrador_perfil->permissions()->attach($doencasbase_show);
		$administrador_perfil->permissions()->attach($doencasbase_export);
		# comorbidades
		$administrador_perfil->permissions()->attach($comorbidade_index);
		$administrador_perfil->permissions()->attach($comorbidade_create);
		$administrador_perfil->permissions()->attach($comorbidade_edit);
		$administrador_perfil->permissions()->attach($comorbidade_delete);
		$administrador_perfil->permissions()->attach($comorbidade_show);
		$administrador_perfil->permissions()->attach($comorbidade_export);
		# pacientes
		$administrador_perfil->permissions()->attach($paciente_index);
		$administrador_perfil->permissions()->attach($paciente_create);
		$administrador_perfil->permissions()->attach($paciente_edit);
		$administrador_perfil->permissions()->attach($paciente_delete);
		$administrador_perfil->permissions()->attach($paciente_show);
		$administrador_perfil->permissions()->attach($paciente_export);
		# monitoramentos
		$administrador_perfil->permissions()->attach($monitoramento_index);
		$administrador_perfil->permissions()->attach($monitoramento_create);
		$administrador_perfil->permissions()->attach($monitoramento_edit);
		$administrador_perfil->permissions()->attach($monitoramento_delete);
		$administrador_perfil->permissions()->attach($monitoramento_show);
		$administrador_perfil->permissions()->attach($monitoramento_export);


		// o gerente (diretor) pode gerenciar os operadores do sistema
		$gerente_perfil->permissions()->attach($user_index);
		$gerente_perfil->permissions()->attach($user_create);
		$gerente_perfil->permissions()->attach($user_edit);
		$gerente_perfil->permissions()->attach($user_show);
		$gerente_perfil->permissions()->attach($user_export);
		# distritos
		$gerente_perfil->permissions()->attach($distrito_index);
		$gerente_perfil->permissions()->attach($distrito_create);
		$gerente_perfil->permissions()->attach($distrito_edit);
		$gerente_perfil->permissions()->attach($distrito_show);
		$gerente_perfil->permissions()->attach($distrito_export);
		# unidades
		$gerente_perfil->permissions()->attach($unidade_index);
		$gerente_perfil->permissions()->attach($unidade_create);
		$gerente_perfil->permissions()->attach($unidade_edit);
		$gerente_perfil->permissions()->attach($unidade_show);
		$gerente_perfil->permissions()->attach($unidade_export);
		# sintomas
		$gerente_perfil->permissions()->attach($sintoma_index);
		$gerente_perfil->permissions()->attach($sintoma_create);
		$gerente_perfil->permissions()->attach($sintoma_edit);
		$gerente_perfil->permissions()->attach($sintoma_show);
		$gerente_perfil->permissions()->attach($sintoma_export);
		# sintomas iniciais ou do cadastro
		$gerente_perfil->permissions()->attach($sintoma_cadastro_index);
		$gerente_perfil->permissions()->attach($sintoma_cadastro_create);
		$gerente_perfil->permissions()->attach($sintoma_cadastro_edit);
		$gerente_perfil->permissions()->attach($sintoma_cadastro_show);
		$gerente_perfil->permissions()->attach($sintoma_cadastro_export);
		# doenças base
		$gerente_perfil->permissions()->attach($doencasbase_index);
		$gerente_perfil->permissions()->attach($doencasbase_create);
		$gerente_perfil->permissions()->attach($doencasbase_edit);
		$gerente_perfil->permissions()->attach($doencasbase_show);
		$gerente_perfil->permissions()->attach($doencasbase_export);
		# comorbidades
		$gerente_perfil->permissions()->attach($comorbidade_index);
		$gerente_perfil->permissions()->attach($comorbidade_create);
		$gerente_perfil->permissions()->attach($comorbidade_edit);
		$gerente_perfil->permissions()->attach($comorbidade_show);
		$gerente_perfil->permissions()->attach($comorbidade_export);
		# pacientes
		$gerente_perfil->permissions()->attach($paciente_index);
		$gerente_perfil->permissions()->attach($paciente_create);
		$gerente_perfil->permissions()->attach($paciente_edit);
		$gerente_perfil->permissions()->attach($paciente_delete);
		$gerente_perfil->permissions()->attach($paciente_show);
		$gerente_perfil->permissions()->attach($paciente_export);
		# monitoramentos
		$gerente_perfil->permissions()->attach($monitoramento_index);
		$gerente_perfil->permissions()->attach($monitoramento_create);
		$gerente_perfil->permissions()->attach($monitoramento_edit);
		$gerente_perfil->permissions()->attach($monitoramento_delete);
		$gerente_perfil->permissions()->attach($monitoramento_show);
		$gerente_perfil->permissions()->attach($monitoramento_export);


		// o operador é o nível de operação do sistema não pode criar
		// outros operadores
		$operador1_perfil->permissions()->attach($user_index);
		$operador1_perfil->permissions()->attach($user_show);
		$operador1_perfil->permissions()->attach($user_export);
		# distritos
		$operador1_perfil->permissions()->attach($distrito_index);
		$operador1_perfil->permissions()->attach($distrito_show);
		$operador1_perfil->permissions()->attach($distrito_export);
		#unidade
		$operador1_perfil->permissions()->attach($unidade_index);
		$operador1_perfil->permissions()->attach($unidade_show);
		$operador1_perfil->permissions()->attach($unidade_export);
		#sintoma
		$operador1_perfil->permissions()->attach($sintoma_index);
		$operador1_perfil->permissions()->attach($sintoma_show);
		$operador1_perfil->permissions()->attach($sintoma_export);
		#sintoma
		$operador1_perfil->permissions()->attach($sintoma_cadastro_index);
		$operador1_perfil->permissions()->attach($sintoma_cadastro_show);
		$operador1_perfil->permissions()->attach($sintoma_cadastro_export);
		#doenças de base
		$operador1_perfil->permissions()->attach($doencasbase_index);
		$operador1_perfil->permissions()->attach($doencasbase_show);
		$operador1_perfil->permissions()->attach($doencasbase_export);
		#comorbidades
		$operador1_perfil->permissions()->attach($comorbidade_index);
		$operador1_perfil->permissions()->attach($comorbidade_show);
		$operador1_perfil->permissions()->attach($comorbidade_export);
		#paciente
		$operador1_perfil->permissions()->attach($paciente_index);
		$operador1_perfil->permissions()->attach($paciente_create);
		$operador1_perfil->permissions()->attach($paciente_edit);
		$operador1_perfil->permissions()->attach($paciente_show);
		$operador1_perfil->permissions()->attach($paciente_export);
		#paciente
		$operador1_perfil->permissions()->attach($monitoramento_index);
		$operador1_perfil->permissions()->attach($monitoramento_create);
		$operador1_perfil->permissions()->attach($monitoramento_edit);
		$operador1_perfil->permissions()->attach($monitoramento_show);
		$operador1_perfil->permissions()->attach($monitoramento_export);


		// o operador é o nível de operação do sistema não pode criar
		// outros operadores
		$operador2_perfil->permissions()->attach($user_index);
		$operador2_perfil->permissions()->attach($user_show);
		$operador2_perfil->permissions()->attach($user_export);
		# distritos
		$operador2_perfil->permissions()->attach($distrito_index);
		$operador2_perfil->permissions()->attach($distrito_show);
		$operador2_perfil->permissions()->attach($distrito_export);
		#unidade
		$operador2_perfil->permissions()->attach($unidade_index);
		$operador2_perfil->permissions()->attach($unidade_show);
		$operador2_perfil->permissions()->attach($unidade_export);
		#sintoma
		$operador2_perfil->permissions()->attach($sintoma_index);
		$operador2_perfil->permissions()->attach($sintoma_show);
		$operador2_perfil->permissions()->attach($sintoma_export);
		#sintoma
		$operador2_perfil->permissions()->attach($sintoma_cadastro_index);
		$operador2_perfil->permissions()->attach($sintoma_cadastro_show);
		$operador2_perfil->permissions()->attach($sintoma_cadastro_export);
		#doenças de base
		$operador2_perfil->permissions()->attach($doencasbase_index);
		$operador2_perfil->permissions()->attach($doencasbase_show);
		$operador2_perfil->permissions()->attach($doencasbase_export);
		#comorbidades
		$operador2_perfil->permissions()->attach($comorbidade_index);
		$operador2_perfil->permissions()->attach($comorbidade_show);
		$operador2_perfil->permissions()->attach($comorbidade_export);
		#paciente
		$operador2_perfil->permissions()->attach($paciente_index);
		$operador2_perfil->permissions()->attach($paciente_create);
		$operador2_perfil->permissions()->attach($paciente_edit);
		$operador2_perfil->permissions()->attach($paciente_show);
		$operador2_perfil->permissions()->attach($paciente_export);
		#monitoramento
		#nenhum




		// leitura é um tipo de operador que só pode ler
		// os dados na tela
		$leitor_perfil->permissions()->attach($user_index);
		$leitor_perfil->permissions()->attach($user_show);
		# distritos
		$leitor_perfil->permissions()->attach($distrito_index);
		$leitor_perfil->permissions()->attach($distrito_show);
		# unidades
		$leitor_perfil->permissions()->attach($unidade_index);
		$leitor_perfil->permissions()->attach($unidade_show);
		# sintoma
		$leitor_perfil->permissions()->attach($sintoma_index);
		$leitor_perfil->permissions()->attach($sintoma_show);
		# sintoma
		$leitor_perfil->permissions()->attach($sintoma_cadastro_index);
		$leitor_perfil->permissions()->attach($sintoma_cadastro_show);
		# doencas base
		$leitor_perfil->permissions()->attach($doencasbase_index);
		$leitor_perfil->permissions()->attach($doencasbase_show);
		# comorbidades
		$leitor_perfil->permissions()->attach($comorbidade_index);
		$leitor_perfil->permissions()->attach($comorbidade_show);
		# pacientes
		$leitor_perfil->permissions()->attach($paciente_index);
		$leitor_perfil->permissions()->attach($paciente_show);
		# monitoramentos
		$leitor_perfil->permissions()->attach($monitoramento_index);
		$leitor_perfil->permissions()->attach($monitoramento_show);

    }
}
