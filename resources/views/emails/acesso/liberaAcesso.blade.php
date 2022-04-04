@component('mail::message')
    Olá, {{$dado['nome']}}
    Seu acesso a plataforma foi liberado pelo administrador.<br/><br/>
    @component('mail::button', ['url' => $url, 'color' => 'primary'])
       Acessar sistema
    @endcomponent

    Obrigado,
    {{ config('app.name') }}
@endcomponent
