<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'descricao', 'peso', 'unidade_id'];

    public function produtoDetalhe(){
        //Produto tem 1 ProdutoDetalhe -> procura um registro relacionado em produto_detalhes com base na FK(produto_id) recebendo o parâmetro da PK de produtos(id)
        return $this->hasOne('App\ProdutoDetalhe');
    }
}
