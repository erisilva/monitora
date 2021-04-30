<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoencasBasePacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doencas_base_paciente', function (Blueprint $table) {
          $table->bigInteger('doencas_base_id')->unsigned();
          $table->bigInteger('paciente_id')->unsigned();
          $table->foreign('doencas_base_id')->references('id')->on('doencas_bases')->onDelete('cascade');
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
        Schema::table('doencas_base_paciente', function (Blueprint $table) {
            $table->dropForeign('doencas_base_paciente_doencas_base_id_foreign');
            $table->dropForeign('doencas_base_paciente_paciente_id_foreign');
        });
        Schema::dropIfExists('doencas_base_paciente');
    }
}
