@component('mail::message')

# Olá {{ $name }}, bem vind{{ $gender == 2 ? 'a' : 'o' }} ao {{ config('app.name') }}!
## Vamos concluir a criação da sua conta?
<p>
    Para concluir a criação da sua conta, precisamos apenas que você confirme que este email pertence a você clicando no link de verificação abaixo.
</p>

@component('mail::button', ['url' => $verificationLink])
Verificar conta
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
