<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\SiteContato;
use \App\Models\MotivoContato;

class ContatoController extends Controller
{
    public function contato(Request $request)
    {

        //     echo "<pre>";
        //     print_r($request->all());
        //     echo "</pre>";
        //   //  echo var_dump($_POST);

        // $contato = new SiteContato();
        // $contato->nome = $request->input('nome');
        // $contato->telefone = $request->input('telefone');
        // $contato->email = $request->input('email');
        // $contato->motivo_contato = $request->input('motivo_contato');
        // $contato->mensagem = $request->input('mensagem');

        // $contato->save();

        // verificar fillable no models para funcionar o metodo fill
       // $contato = new SiteContato();
       // $contato->fill($request->all());
        
        //$contato->create($request->all());

       // print_r($contato->getAttributes());

       $motivo_contato = MotivoContato::all();

        return view('site.contato' , ['titulo' => 'Contato (teste)' , 'motivo_contato' => $motivo_contato]);
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3|max:40', //nomes no minimo 3 char e max 40
            'telefone' => 'required',
            'email' => 'required',
            'motivo_contato' => 'required',
            'mensagem' => 'required|max:2000'
        ]);
        //realizar a validacao do formulario na variavel request
       //SiteContato::create($request->all());
    }
}
