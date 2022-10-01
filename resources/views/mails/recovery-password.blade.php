@component('mail::message')
# {{ $name }}, aqui está seu link de recuperação de senha!

Para recuperar sua senha é simples, apenas clique no botão abaixo para iniciar o processo de recuperação.

@component('mail::button', ['url' => $recoveryLink])
Recuperar minha senha
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
