<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
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
    public function index(Request $request)
    {

        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('atributos_modelos')){
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);

            
        }else{
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if($request->has('filtro')){

            $marcaRepository->filtro($request->filtro);

            // $condicoes = explode(':', $request->filtro);
            // $modelos = $modelos->where($condicoes[0], $condicoes[1], $condicoes[2]);
        }

        if ($request->has('atributos')) {
           $marcaRepository->selectAtributos($request->atributos);

        }



        //----------------------------------------------
        //
        /*
        $marcas = array();

        if($request->has('atributos_modelos')){
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcas = $this->marca->with($atributos_modelos);
        }else{
            $marcas = $this->marca->with('modelos');
        }

        if($request->has('filtro')){

            $filtros = explode(';',$request->filtro);
            foreach($filtros as $key => $condicao){
                $c = explode(':',$condicao);
                $marcas = $marcas->where($c[0],$c[1],$c[2]);
            }

            // $condicoes = explode(':', $request->filtro);
            // $modelos = $modelos->where($condicoes[0], $condicoes[1], $condicoes[2]);
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;
            
            $marcas =  $marcas->selectRaw($atributos)->get();
        } else {
            $marcas = $marcas->get();
        }

        //$marcas = Marca::all();
       // $marcas = $this->marca->with('modelos')->get();
       */
        return $marcaRepository->get();
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
        $marca = $this->marca->with('modelos')->find($id);
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

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();
       
        // $marca->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);

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
        return ['msg' => 'Marca excluída com sucesso!'];
    }
}
