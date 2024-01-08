<?php

use Illuminate\Database\Seeder;
use App\Fornecedor;
use Illuminate\Support\Facades\DB;

class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Criando o registro instanciando o objeto
        $fornecedor = new Fornecedor();
        $fornecedor->nome = 'Esola Técnica Jujutsu de Tóquio';
        $fornecedor->site = 'escola-jjk-tk.com.jp';
        $fornecedor->uf = 'TK';
        $fornecedor->email = 'escola@jjk.com.jp';
        $fornecedor->save();

        //Usando o método create - ATENÇÃO PARA O ATRIBUTO FILLABLE DA CLASSE
        Fornecedor::create([
            'nome' => 'Tropa de Exploração',
            'site' => 'tropa-exploracao.com.jp',
            'uf' => 'PD',
            'email' => 'tropa@att.com.jp'
        ]);

       //Usando insert
       DB::table('fornecedores')->insert([
            'nome' => 'Vila da Folha',
            'site' => 'konoha.com.jp',
            'uf' => 'PF',
            'email' => 'konoha@nr.com.jp'
       ]);
    }
}
