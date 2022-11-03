<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function index(Request $request)
    {

        $erro = $request->get('erro');
        if ($erro == 1) {
            $erro = 'Usuário ou senha invalidos';
        }
        if ($erro == 2) {
            $erro = 'Nescessario realizar login';
        }
        return view('site.login', ['titulo' => 'Login', 'erro' => $erro]);
    }

    public function autenticar(Request $request)
    {

        $regras = [
            'usuario' => 'email',
            'senha' => 'required'
        ];

        //mensagens de feedback
        $feedback = [
            'usuario.email' => 'O campo usuário precisa ser um email válido',
            'senha.required' => 'O campo senha precisa ser preenchido'
        ];

        $request->validate($regras, $feedback);

        $email = $request->get('usuario');
        $password = $request->get('senha');

        //iniciar model user
        $user = new User();

        $usuario = $user->where('email', $email)
            ->where(
                'password',
                $password
            )->get()
            ->first();

        if (isset($usuario->name)) {

            session_start();
            $_SESSION['nome'] = $usuario->name;
            $_SESSION['email'] = $usuario->email;
            return redirect()->route('app.home');
        } else {
            return redirect()->route('site.login', ['erro' => 1]);
        }

        print_r($request->all());
    }

    public function sair(){
        session_destroy();
        return redirect()->route('site.index');
    }

}
