<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('hora_id')->unsigned();
            $table->integer('servico_id')->unsigned();
            $table->integer('profissional_id')->unsigned();
            $table->string('data');
            $table->timestamps();
        });

        Schema::table('agendas', function (Blueprint $table) {
         $table->foreign('user_id')->references('id')->on('users');
         $table->foreign('hora_id')->references('id')->on('horas');
         $table->foreign('servico_id')->references('id')->on('servicos');
         $table->foreign('profissional_id')->references('id')->on('profissionals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendas');
    }
}
