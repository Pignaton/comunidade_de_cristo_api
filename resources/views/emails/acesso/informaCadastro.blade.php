@component('mail::message')
    Olá, {{$dado['nome']}}
    Parabéns, seu cadastro foi finalizado com sucesso,<br/>
    pórem para acessar o plataforma será necessário liberação do administrador<br/><br/>
    @component('mail::button', ['url' => $url])
        Acessar sistema
    @endcomponent

    Obrigado,
    {{ config('app.name') }}
@endcomponent
