<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;
    
    protected $table = 'fornecedores';
    protected $fillable = ['nome', 'site', 'uf', 'email'];

    public function produtos(){
        //1º parâmetro: referência do relacionamento(o model que representa a tabela no banco de dados)
        //2º parâmetro: FK do relacionamento
        //3º parâmetro: Coluna que representa a PK na tabela que estabelece o relacionamento
        //os últimos dois parâmetros podem ser omitidos, caso os nomes sejam os padrões: return $this->hasMany('App\Item');
        return $this->hasMany('App\Item', 'fornecedor_id', 'id');
    }
}
