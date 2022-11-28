<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Models\Locacao;
use Illuminate\Http\Request;
use App\Repositories\LocacaoRepository;

class LocacaoController extends Controller
{
    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $locacaoRepository = new LocacaoRepository($this->locacao);


        if($request->has('filtro')){

            $locacaoRepository->filtro($request->filtro);

            // $condicoes = explode(':', $request->filtro);
            // $modelos = $modelos->where($condicoes[0], $condicoes[1], $condicoes[2]);
        }

        if ($request->has('atributos')) {
           $locacaoRepository->selectAtributos($request->atributos);

        }

        return $locacaoRepository->get();
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
     * @param  \App\Http\Requests\StoreLocacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       // $request->validate($this->locacao->rules());

     
        $locacao = $this->locacao->create(
            [
                'cliente_id' => $request->cliente_id,
                'carro_id' => $request->carro_id,
                'data_inicio_periodo' => $request->data_inicio_periodo,
                'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
                'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
                'valor_diaria' => $request->valor_diaria,
                'km_inicial' => $request->km_inicial,
                'km_final' => $request->km_final
            ]
        );
        return $locacao;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $locacao = $this->locacao->find($id);
        if ($locacao === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }
        return $locacao;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Locacao $locacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLocacaoRequest  $request
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $locacao = $this->locacao->find($id);
        if ($locacao === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe.'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            //percorrer todas as regras
            foreach ($locacao->rules() as $input => $regra) {
                //coletar apenas as regras aplicaveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($locacao->rules());
        }

       
        $locacao->fill($request->all());
     
        $locacao->save();
       
        // $locacao->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);

        return $locacao;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $locacao = $this->locacao->find($id);
        if ($locacao === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe'], 404);
        }

        
        $locacao->delete();
        return ['msg' => 'A locacao foi excluída com sucesso!'];
    }
}
