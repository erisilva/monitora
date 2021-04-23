<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacienteSintomasCadastroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_sintomas_cadastro', function (Blueprint $table) {
          $table->bigInteger('sintomas_cadastro_id')->unsigned();
          $table->bigInteger('paciente_id')->unsigned();
          $table->foreign('sintomas_cadastro_id')->references('id')->on('sintomas_cadastros')->onDelete('cascade');
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
        Schema::table('paciente_sintomas_cadastro', function (Blueprint $table) {
            $table->dropForeign('paciente_sintomas_cadastro_sintomas_cadastro_id_foreign');
            $table->dropForeign('paciente_sintomas_cadastro_paciente_id_foreign');
        });
        Schema::dropIfExists('paciente_sintomas_cadastro');
    }
}
