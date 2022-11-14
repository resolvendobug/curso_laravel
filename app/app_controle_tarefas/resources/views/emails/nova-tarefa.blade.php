@component('mail::message')
# {{ $tarefa }}

Data limite de Conclusão: {{ $data_limite_conclusao }}

@component('mail::button', ['url' => $url ])
Clique aqui para ver a tarefa
@endcomponent

Att,<br>
{{ config('app.name') }}
@endcomponent
