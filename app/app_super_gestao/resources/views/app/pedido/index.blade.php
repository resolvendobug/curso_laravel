@extends('app.layouts.basico')
@section('titulo', 'Pedidos- Listar')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Listagem de Pedidos</p>
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{ route('pedido.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>
        <div class="informacao-pagina">
            <div style="width: 90%;margin-left:auto;margin-right:auto;">
                
                    <table border="1" width="100%">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->cliente->id }}</td>
                            
                            <td><a href="{{ route('pedido.show' , ['pedido'  => $pedido->id ]) }}">Visualizar</a></td>
                            <td>
                                <form id="form_{{ $pedido->id }}" method="post" action="{{ route('pedido.destroy', ['pedido' => $pedido->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <a href="#" onclick="document.getElementById('form_{{ $pedido->id }}').submit()">Excluir</a>
                                </form>
                            </td>
                            <td><a href="{{ route('pedido.edit' , ['pedido'  => $pedido->id ]) }}">Editar</a></td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $pedidos->appends($request)->links() }}
            </div>
        </div>
    </div>
@endsection
