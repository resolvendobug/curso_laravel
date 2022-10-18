<h3>Fornecedores</h3>

{{-- fica o comentario que sera descartado pelo blade --}}
{{ 'teste ' }}

@php 
    //para comentarios de uma linha
    /* bloco */
@endphp



@if(count($fornecedores) > 0 && count($fornecedores) < 10)
    <h3>Existem alguns fornecedores cadastrados</h3>
@elseif(count($fornecedores) > 10)
    <h3>Existem varios fornecedores cadastrados</h3>
@else
    <h3>Ainda nao existem fornecedores cadastrados</h3>
@endif

