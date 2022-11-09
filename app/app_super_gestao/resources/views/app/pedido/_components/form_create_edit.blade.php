@if (isset($pedido->id))
    <form method="POST" action="{{ route('pedido.update', ['pedido' => $pedido->id]) }}">
        @method('PUT')
    @else
        <form method="POST" action="{{ route('pedido.store') }}">
@endif
@csrf

<select name="cliente_id">
    <option value="">Selecione um cliente</option>
    @foreach ($clientes as $cliente)
        <option value="{{ $cliente->id }}" {{ (isset($pedido->cliente_id) && $pedido->cliente_id == $cliente->id) || old('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
    @endforeach
</select>

{{ $errors->has('nome') ? $errors->first('nome') : '' }}

<button type="submit" class="borda-preta">Cadastrar</button>
</form>
