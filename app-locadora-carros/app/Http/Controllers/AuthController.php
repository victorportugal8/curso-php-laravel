<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $credenciais = $request->all(['email', 'password']); //all() -> pode receber um array por parâmetro indicando o que receber
        //autenticação do usuário(e-mail e senha)
        $token = auth('api')->attempt($credenciais);
        
        if($token){
            //usuário autenticado
            return response()->json(['token' => $token]);
        } else{
            //erro de usuário ou senha
            return response()->json(['erro' => 'Usuário ou senha inválidos!'], 403); //401: Unauthorized -> pode estar logado, mas não autorizado; 403: forbbiden -> login inválido;
        }
        //retorna o JWT para o usuário
        return 'Login';
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['msg' => 'Logout realizado com sucesso!']);
    }

    public function refresh(){
        $token = auth('api')->refresh(); //o client precisa encaminhar um JWT válido
        return response()->json(['token' => $token]);
    }

    public function me(){
        return response()->json(auth()->user());
    }
}
