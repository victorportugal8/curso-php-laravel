<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function produtos(){
        //nomes padronizados:
        //1º parâmetro é o model que mapeia a tabela do relacionamento NxN;
        //2º parâmetro é a tabela que guarda o relacionamento NxN;
        // return $this->belongsToMany('App\Produto', 'pedidos_produtos');

        //nomes não padronizados: 
        //1º parâmetro é o model que mapeia a tabela do relacionamento NxN;
        //2º parâmetro é a tabela auxiliar que armazena os registros do relacionamento;
        //3º parâmetro representa o nome da FK da tabela mapeada pelo model na tabela de relacionamento;
        //4º parâmetro representa o nome da FK da tabela mapeada pelo model utilizado no relacionamento implementado;
        return $this->belongsToMany('App\Item', 'pedidos_produtos', 'pedido_id', 'produto_id')->withPivot('id', 'created_at');
    }
}
