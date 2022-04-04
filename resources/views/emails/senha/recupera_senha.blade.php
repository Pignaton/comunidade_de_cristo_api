@component('mail::message')
    Olá, {{$dado['nome']}}!<br/><br/>
    Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.
    @component('mail::button', ['url' => $url, 'color' => 'primary'])
        Modificar Senha
    @endcomponent
    Este link de redefinição de senha expirará em 30 minutos.<br/><br/>
    Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.<br/><br/>
    @lang('Regards'),<br/>
    {{ config('app.name') }}
    @slot('subcopy')
        @lang(
            'Se você está tendo problemas para clicar no botão "Modificar Senha", copie e cole a URL abaixo em seu navegador web:',
            [
                'actionText' => 'Modificar Senha',
            ]
        ) <span class="break-all">[{{ $url }}]({{ $url }})</span>
    @endslot
@endcomponent
