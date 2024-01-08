<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProdutosRelacionamentoFornecedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //cria a coluno em produtos para receber a FK de fornecedores(fornecedor_id)
        Schema::table('produtos', function(Blueprint $table){
            //insere um registro de fornecedor para estabelecer o relacionamento -> caso não haja registros no banco, não é necessário realizar essa instrução!!!
            $fornecedor_id = DB::table('fornecedores')->insertGetId([
                'nome' => 'Seireitei',
                'site' => 'seireitei.jp.com',
                'uf' => 'SS',
                'email' => 'seireitei@bl.jp'
            ]);

            $table->unsignedBigInteger('fornecedor_id')->default($fornecedor_id)->after('id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function(Blueprint $table){
            $table->dropForeign('produtos_fornecedor_id_foreign');
            $table->dropColumn('fornecedor_id');
        });
    }
}
