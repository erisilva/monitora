<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            //dados principais
            $table->string('nome');
            $table->string('nomeMae');
            $table->date('nascimento');
            $table->string('cns')->nullable();
            $table->integer('idade');

            // endereço
            $table->string('cep');
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('cidade');
            $table->string('uf');

            // contatos
            $table->string('cel1'); // ogrigatorio
            $table->string('cel2')->nullable();
            $table->string('email')->nullable();

            //unidade de origem
            $table->bigInteger('unidade_id')->unsigned();

            // dados iniciais de monitoramento
            $table->date('ultimoMonitoramento')->nullable();
            $table->string('tomouVacina'); // pode ser: não, 1 dose, 2 doses
            $table->date('inicioSintomas');
            // iniciar monitoramento - Não monitorado, Monitorando, Finalizado
            // finalizar monitoramento,
            // reiniciar monitoramento, voltar a fazer o monitoramento
            $table->enum('monitorando', ['s', 'n', 'f']);

            // operador que fez o cadastro
            $table->bigInteger('user_id')->unsigned();

            $table->text('notas')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // fks
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropForeign('pacientes_unidade_id_foreign');
            $table->dropForeign('pacientes_user_id_foreign');

            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('pacientes');
    }
}
