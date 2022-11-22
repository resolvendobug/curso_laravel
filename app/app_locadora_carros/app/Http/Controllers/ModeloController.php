<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $modelo = $this->modelo->all();
        return $modelo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate($this->modelo->rules());

        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens/modelos','public');

        $modelo = $this->modelo->create(
            [
                'marca_id' => $request->marca_id,
                'nome' => $request->nome,
                'imagem' => $imagem_urn,
                'numero_portas' => $request->numero_portas,
                'lugares' => $request->lugares,
                'air_bag' => $request->air_bag,
                'abs' => $request->abs
            ]
        );
        return $modelo;
    }

    /**
     * Display the specified resource.
     *  
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $modelo = $this->modelo->find($id);
        if ($modelo === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }
        return $modelo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $modelo = $this->modelo->find($id);
        if ($modelo === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe.'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            //percorrer todas as regras
            foreach ($modelo->rules() as $input => $regra) {
                //coletar apenas as regras aplicaveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($modelo->rules());
        }

        //remove o arquivo antigo , caso um arquivo novo tenha sido enviado
        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);
        }

        

        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens/modelos','public');

       
        $modelo->update([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
        return $modelo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $modelo = $this->marca->find($id);
        if ($modelo === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);
        
        $modelo->delete();
        return ['msh' => 'Modelo excluída com sucesso!'];
    }
}
