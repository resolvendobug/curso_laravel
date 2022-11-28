<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        
        $credenciais = $request->all(['email','password']);
        
        //autenticacao(email e senha)
        $token = auth('api')->attempt($credenciais);
        
        if($token){
            return response()->json(['token'=>$token],200);
        }else {
            return response()->json(['erro'=>'Credenciais invalidas'],403);
        }

        //401 = Unauthorized -> nao autorizado
        //403 = Forbidden -> proibido (login invalido)
        
        //dd($token);

        //retornar um Json Web Token 
        return 'login';
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['msg'=>'Logout realizado com sucesso'],200);
    }

    public function refresh(){
        $token = auth('api')->refresh(); // o cliente encaminhe um jwt valido
        return response()->json(['token'=>$token],200);
    }

    public function me(){
        return response()->json(auth()->user());
    }

}
