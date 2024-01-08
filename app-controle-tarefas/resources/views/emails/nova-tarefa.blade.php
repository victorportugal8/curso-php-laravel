@component('mail::message')
# {{$tarefa}}

Data limite para conclusão: {{$data_limite_conclusao}}

@component('mail::button', ['url' => $url])
Clique aqui para ver a tarefa
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
