<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonitoramentoSintomaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoramento_sintoma', function (Blueprint $table) {
          $table->bigInteger('monitoramento_id')->unsigned();
          $table->bigInteger('sintoma_id')->unsigned();
          $table->foreign('monitoramento_id')->references('id')->on('monitoramentos')->onDelete('cascade');
          $table->foreign('sintoma_id')->references('id')->on('sintomas')->onDelete('cascade');
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
        Schema::table('monitoramento_sintoma', function (Blueprint $table) {
            $table->dropForeign('monitoramento_sintoma_monitoramento_id_foreign');
            $table->dropForeign('monitoramento_sintoma_sintoma_id_foreign');
        });
        Schema::dropIfExists('monitoramento_sintoma');
    }
}
