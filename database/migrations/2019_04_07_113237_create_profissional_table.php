<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfissionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('profissionals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servico_id')->unsigned();
            $table->string('profissional');
            $table->string('endereco');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('telefone');
            $table->string('rg');
            $table->string('cpf');
            $table->timestamps();
        });
       Schema::table('agendas', function (Blueprint $table) {
         $table->foreign('servico_id')->references('id')->on('servicos');
       });
    }
      
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
