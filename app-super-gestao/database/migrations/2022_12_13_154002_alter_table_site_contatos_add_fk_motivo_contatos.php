<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterTableSiteContatosAddFkMotivoContatos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Adicionando a coluna motivo_contatos_id
        Schema::table('site_contatos', function(Blueprint $table){
            $table->unsignedBigInteger('motivo_contatos_id');
        });

        //Executa uma query que atribuí motivo_contato a nova coluna motivo_contatos_id no BD
        DB::statement('update site_contatos set motivo_contatos_id = motivo_contato');

        //Criando FK e removendo a coluno motivo_contato
        Schema::table('site_contatos', function(Blueprint $table){
            $table->foreign('motivo_contatos_id')->references('id')->on('motivo_contatos');
            $table->dropColumn('motivo_contato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Criando a coluna motivo_contato e removendo a FK
        Schema::table('site_contatos', function(Blueprint $table){
            $table->integer('motivo_contato');
            $table->dropForeign('site_contatos_motivo_contatos_id_foreing');
        });

        //Executa uma query que atribuí motivo_contatos_id a coluna motivo_contato no BD
        DB::statement('update site_contatos set motivo_contato = motivo_contatos_id');

        //Removendo a coluna motivo_contatos_id
        Schema::table('site_contatos', function(Blueprint $table){
            $table->dropColumn('motivo_contatos_id');
        });
    }
}
