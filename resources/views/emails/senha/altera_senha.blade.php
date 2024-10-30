@component('mail::message')
    Olá! Você está recebendo este e-mail porque recebemos uma solicitação de alteração de senha para sua conta.<br/><br/>
    Para fazer sua validação, digite o seguinte código no aplicativo.<br/>
    @component('mail::button', ['url' => '', 'color' => 'primary', 'style' => 'font-size: 30px; padding: 20px 40px;'])
        {{$dado['code']}}
    @endcomponent
    <br/>Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.<br/><br/>
    @lang('Regards'),<br/>
    {{ config('app.name') }}
@endcomponent
