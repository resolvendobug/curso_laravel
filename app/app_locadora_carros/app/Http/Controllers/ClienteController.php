<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $clienteRepository = new ClienteRepository($this->cliente);



       
        if($request->has('filtro')){

            $clienteRepository->filtro($request->filtro);

        }

        if ($request->has('atributos')) {
           $clienteRepository->selectAtributos($request->atributos);

        }

        return $clienteRepository->get();
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClienteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate($this->cliente->rules());

     
        $cliente = $this->cliente->create(
            [
                'nome' => $request->nome,
            ]
        );
        return $cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cliente = $this->cliente->find($id);
        if ($cliente === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }
        return $cliente;
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClienteRequest  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cliente = $this->cliente->find($id);
        if ($cliente === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe.'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            //percorrer todas as regras
            foreach ($cliente->rules() as $input => $regra) {
                //coletar apenas as regras aplicaveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($cliente->rules());
        }

       
        $cliente->fill($request->all());
     
        $cliente->save();
       
        // $cliente->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);

        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cliente = $this->cliente->find($id);
        if ($cliente === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }

        
        $cliente->delete();
        return ['msg' => 'O cliente foi excluído com sucesso!'];
    }
}
