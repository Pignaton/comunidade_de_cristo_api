<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class=" mx-auto w-full grid place-items-center h-screen">
    <div class="flex flex-col">
        <i class="fa-regular fa-circle-check icon"></i>
        <p class="text">Senha alterada com sucesso</p>
        <div class="box-btn">
            <a href="comunidadeblog.tk" class="btn flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Voltar para login</a>
        </div>
    </div>
    <div class="bg-gray-200 text-center footer">
        <p class="text-center text-gray-500 text-xs">
            &copy;{{date('Y')}} {{config('app.name')}}. Todos os direitos reservados.
        </p>
    </div>
</div>
</body>
</html>
