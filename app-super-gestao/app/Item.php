<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'produtos';
    protected $fillable = ['nome', 'descricao', 'peso', 'unidade_id', 'fornecedor_id'];

    public function itemDetalhe(){
        //2º parâmetro: nome da coluna da FK no banco de dados
        //3º parâmetro: nome da PK no banco de dados
        return $this->hasOne('App\ItemDetalhe', 'produto_id', 'id');
    }

    public function fornecedor(){ //estabelece que 1 produto pertence a 1 fornecedor
        return $this->belongsTo('App\Fornecedor');
    }

    public function pedidos(){
        //nomes não padronizados: 
        //1º parâmetro é o model que mapeia a tabela do relacionamento NxN;
        //2º parâmetro é a tabela auxiliar que armazena os registros do relacionamento;
        //3º parâmetro representa o nome da FK da tabela mapeada pelo model na tabela de relacionamento;
        //4º parâmetro representa o nome da FK da tabela mapeada pelo model utilizado no relacionamento implementado;
        return $this->belongsToMany('App\Pedido', 'pedidos_produtos', 'produto_id', 'pedido_id');
    }
}
