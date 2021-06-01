<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoramentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoramentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('paciente_id')->unsigned();

            // sintomas

            $table->string('febre'); // sim ou não
            $table->string('diabetico'); // sim ou não
            $table->string('glicemia'); // Não, Menos de 200, 200 a 300, Mais de 350, Não Atendeu
            // doenças de base
            //$table->string('teste'); // Sim, não, não sabe
            // Marca como está o exame de rt-pcr do paciente    
            $table->bigInteger('rtpcr_id')->unsigned(); // nesse caso o indice 1 não será usado
            $table->string('tomouVacina'); //"Não tomou", "Tomou 1 dose"; "Tomou 2 doses", "Nao Sabe" e não atendeu
            //$table->string('resultado'); // resultado do teste: Positivo, negativo, indeterminado, não sabe
            $table->text('historico')->nullable();  // historico clínico
            // operador que fez o cadastro
            $table->bigInteger('user_id')->unsigned();
            $table->string('saude'); // como está sua saúde hoje: pior, igual, melhor
            $table->string('familia'); // existem pessoas na família com covid? sim, não, não sabe, não atendeu
            $table->string('quantas')->nullable(); // numerico e opcional


            $table->timestamps();

            // fks
            $table->foreign('rtpcr_id')->references('id')->on('rtpcrs')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
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
        Schema::table('monitoramentos', function (Blueprint $table) {
            $table->dropForeign('monitoramentos_paciente_id_foreign');
            $table->dropForeign('monitoramentos_user_id_foreign');
            $table->dropForeign('monitoramentos_rtpcr_id_foreign');
        });
        Schema::dropIfExists('monitoramentos');
    }
}
