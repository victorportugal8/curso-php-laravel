<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteContato;
use App\MotivoContato;

class ContatoController extends Controller
{
    public function contato(Request $request){
        /*
        //utilizado quando é necessário fazer algum tratamento nos dados
        $contato = new SiteContato();
        
        $contato->nome = $request->input('nome');
        $contato->telefone = $request->input('telefone');
        $contato->email = $request->input('email');
        $contato->motivo_contato = $request->input('motivo_contato');
        $contato->mensagem = $request->input('mensagem');
        */

        /*
        $contato->save();

        $contato = new SiteContato();
        
        $contato->fill($request->all());
        
        $contato->save();
        */

        //método create - quando não temos nenhuma lógica de tratamento sofisticada
        // $contato = new SiteContato();

        // $contato->create($request->all());

        $motivo_contatos = MotivoContato::all();

        return view('site.contato', ['titulo' => 'Contato', 'motivo_contatos' => $motivo_contatos]);
    }

    public function salvar(Request $request){
        //criando as regras de erros
        $regras = [
            'nome' => 'required|min:3|max:40|unique:site_contatos', //nomes com no min 3 e no max 40 caracteres e validação de campo único(unique - apenas para fins de teste)
            'telefone' => 'required',
            'email' => 'email', //verifica se o dado informado representa um endereço de e-mail válido
            'motivo_contatos_id' => 'required',
            'mensagem' => 'required|max:2000' //mensagem com no máximo 2K de caracteres
        ];
        
        //criando as mensagens de feedback de erros
        $feedback = [
            'nome.min' => 'O campo nome precisa ter PELO MENOS 3 caracteres.',
            'nome.max' => 'O campo nome só pode ter no MÁXIMO 40 caracteres.',
            'nome.unique' => 'O nome informado já está em uso.',
            'email.email' => 'O e-mail informado não é válido.',
            'mensagem.max' => 'A mensagem só pode ter no MÁXIMO 2.000 caracteres.',
            'required' => 'O campo :attribute DEVE ser preenchido.' //opção genérica: todo campo que for requerido, apresentará esta mensagem
        ];

        //realizar a validação dos dados do formulário recebidos o request
        $request->validate($regras, $feedback);
        
        //habilitando a persistência dos dados e o redirecionamento de rotas
        SiteContato::create($request->all());
        return redirect()->route('site.index');
    }
}