@extends('app.layouts.basico')
@section('titulo', 'Detalhes do Produto')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Editar Detalhes Produto</p>
        </div>
        <div class="menu">
            <ul>
                <li><a href="#">Voltar</a></li>
                
            </ul>
        </div>
        <div class="informacao-pagina">

            <h4>Produto</h4>
            <div>Nome:{{ $produto_detalhe->produto->nome; }}</div>
            <br>
            <div>Descricao: {{ $produto_detalhe->produto->descricao; }}</div>
            
            <div style="width: 30%;margin-left:auto;margin-right:auto;">
                @component('app.produto_detalhe._components.form_create_edit', ['unidades' => $unidades, 'produto_detalhe' => $produto_detalhe ?? null])
                    
                @endcomponent
            </div>
        </div>
    </div>
@endsection
