<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Fornecedor;

class FornecedorController extends Controller
{
    //
    public function index(){
        return view('app.fornecedor.index');
    }

    public function listar(Request $request){

        $fornecedores = Fornecedor::where('nome', 'like', '%' . $request->nome . '%')
        ->where('site', 'like', '%' . $request->site . '%')
        ->where('uf', 'like', '%' . $request->uf . '%')
        ->where('email', 'like', '%' . $request->email . '%')
        ->get();

        return view('app.fornecedor.listar', ['fornecedores' => $fornecedores]);
    }

    public function adicionar(Request $request){

        $msg = '';
        if($request->input('_token') != ''){
            $regras = [
                'nome' => 'required|min:3|max:40',
                'site' => 'required',
                'uf' => 'required|min:2|max:2',
                'email' => 'email'
            ];

            $feedback = [
                'nome.required' => 'O campo nome precisa ser preenchido.',
                'nome.min' => 'O campo nome precisa ter no minimo 3 caracteres',
                'nome.max' => 'O campo nome deve ter no máximo 30 caracteres',
                'uf.required' => 'O campo UF precisa ser preenchido',
                'uf.min' => 'O campo UF precisa ter 2 caracteres',
                'uf.max' => 'O campo UF precisa ter 2 caracteres',
                'site.required' => 'O campo site precisa ser preenchido',
                'email' => 'O email informado não é válido'
            ];

            $request->validate($regras, $feedback);

            $fornecedor = new Fornecedor();
            $fornecedor->create($request->all());
            $msg = 'Fornecedor cadastrado com sucesso!';

        }
        
        return view('app.fornecedor.adicionar', ['msg' => $msg]);
    }
    
    
}
