<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDetalhe extends Model
{
    protected $table = 'produto_detalhes';
    protected $fillable = ['produto_id', 'comprimento', 'largura', 'altura', 'unidade_id'];

    public function item(){
        //2º parâmetro: nome da FK contida dentro da tabela mapeada
        //3º parâmetro: nome da coluna da PK
        return $this->belongsTo('App\Item', 'produto_id', 'id');
    }
}
