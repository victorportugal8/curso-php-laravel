<?php

namespace App\Http\Controllers;

use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index(){
        return view('app.fornecedor.index');
    }

    public function listar(Request $request){
        $fornecedores = Fornecedor::with(['produtos'])->where('nome', 'like', '%'.$request->input('nome').'%')
                        ->where('site', 'like', '%'.$request->input('site').'%')
                        ->where('uf', 'like', '%'.$request->input('uf').'%')
                        ->where('email', 'like', '%'.$request->input('email').'%')
                        ->paginate(5);
        return view('app.fornecedor.listar', ['fornecedores' => $fornecedores, 'request' => $request->all()]);
    }

    public function adicionar(Request $request){
        $msg = '';
        if($request->input('_token') != '' && $request->input('id') == ''){
            //cadastro de registro - validação de dados
            $regras = [
                'nome' => 'required|min:3|max:40',
                'site' => 'required',
                'uf' => 'required|min:2|max:2',
                'email' => 'email'
            ];

            $feedback = [
                'required' => 'O campo :attribute deve ser preenchido.',
                'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
                'nome.max' => 'O campo nome deve ter no máximo 40 caracteres.',
                'uf.min' => 'O campo UF deve ter no mínimo 2 caracteres.',
                'uf.max' => 'O campo UF deve ter no máximo 2 caracteres.',
                'email.email' => 'O campo e-mail não foi preenchido corretamente.'
            ];

            $request->validate($regras, $feedback);
            
            $fornecedor = new Fornecedor();
            $fornecedor->create($request->all());

            $msg = 'Cadastro realizado com sucesso!';
        }
        //edição dos registros
        if($request->input('_token') != '' && $request->input('id') != ''){
            $fornecedor = Fornecedor::find($request->input('id'));
            $update = $fornecedor->update($request->all());

            if($update){
                $msg = 'Atualização realizada com sucesso!';
            } else{
                $msg = 'Erro ao tentar atualizar o registro, tente novamente.';
            }
            
            return redirect()->route('app.fornecedor.editar', ['id' => $request->input('id'), 'msg' => $msg]);
        }

        return view('app.fornecedor.adicionar', ['msg' => $msg]);
    }

    public function editar($id, $msg = ''){
        $fornecedor = Fornecedor::find($id);

        return view('app.fornecedor.adicionar', ['fornecedor' => $fornecedor, 'msg' => $msg]);
    }

    public function excluir($id){
        Fornecedor::find($id)->delete(); //softDelete -> apenas gera a data de 'exclusão' na tabela do banco de dados
        // Fornecedor::find($id)->forceDelete(); - caso queira realmente excluir o registro da tabela do banco de dados

        return redirect()->route('app.fornecedor');
    }
}
