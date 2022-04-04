<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container mx-auto ">
    <div class="w-full grid place-items-center h-screen ">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 " action="{{url('/valida-senha')}}" method="POST">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                     role="alert">
                    <svg class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="font-medium">Alerta!</span>
                        <p>Preencha os campo obrigatórios.</p>
                    </div>
                </div>
            @endif
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" name="email" type="text" placeholder="Email" readonly value="{{$dado->email}}">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="senha">
                    Senha
                </label>
                <input
                    class="shadow appearance-none border @error('senha') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id=senha name="senha" type="password" placeholder="******************">
                @error('senha')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="confirma_senha">
                    Confirma Senha
                </label>
                <input
                    class="shadow appearance-none border @error('senha') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="confirma_senha" name="confirma_senha" type="password" placeholder="******************">
                @error('senha')
                <p class="text-red-500 text-xs italic">Por favor, confirme a senha.</p>
                @enderror
            </div>
            <div class="flex items-center flex-col grid">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Resetar Senha
                </button>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            &copy;{{date('Y')}} {{config('app.name')}}. Todos os direitos reservados.
        </p>
    </div>
</div>
</body>
</html>
