<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComorbidadePacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comorbidade_paciente', function (Blueprint $table) {
          $table->bigInteger('comorbidade_id')->unsigned();
          $table->bigInteger('paciente_id')->unsigned();
          $table->index(['comorbidade_id', 'paciente_id']); 
          $table->foreign('comorbidade_id')->references('id')->on('comorbidades')->onDelete('cascade');
          $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         // nome_da_tabela + nome_do_campo_chave + _foreign
        Schema::table('comorbidade_paciente', function (Blueprint $table) {
            $table->dropForeign('comorbidade_paciente_comorbidade_id_foreign');
            $table->dropForeign('comorbidade_paciente_paciente_id_foreign');
        });
        Schema::dropIfExists('comorbidade_paciente');
    }
}
