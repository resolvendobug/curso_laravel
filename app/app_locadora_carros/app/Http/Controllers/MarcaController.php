<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$marcas = Marca::all();
        $marcas = $this->marca->all();
        return $marcas;
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
        //  $marca = Marca::create($request->all());

        

        $request->validate($this->marca->rules(), $this->marca->feedback());

        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens','public');

        $marca = $this->marca->create(
            [
                'nome' => $request->nome,
                'imagem' => $imagem_urn
            ]
        );
        return $marca;
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }
        return $marca;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe.'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            //percorrer todas as regras
            foreach ($marca->rules() as $input => $regra) {
                //coletar apenas as regras aplicaveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        //remove o arquivo antigo , caso um arquivo novo tenha sido enviado
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
        }

        

        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens','public');

       
        $marca->update([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }

        Storage::disk('public')->delete($marca->imagem);
        
        $marca->delete();
        return ['msh' => 'Marca excluída com sucesso!'];
    }
}
