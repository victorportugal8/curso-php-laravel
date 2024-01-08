<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules(){
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png'
        ];

        /*
            PARÂMETROS DA VALIDAÇÃO UNIQUE
            1º -> Tabela onde será feita a pesquisa da existência única do valor passado;
            2º -> Nome da coluna que será pesquisada na tabela(por padrão é o nome do input e normalmente é omitido, nesse caso: nome);
            3º -> ID do registro que será desconsiderado na pesquisa;
        */
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório!',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG',
            'nome.unique' => 'O nome da marca já existe.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres'
        ];
    }

    public function modelos(){
        //UMA marca possui MUITOS modelos
        return $this->hasMany('App\Models\Modelo');
    }
}
