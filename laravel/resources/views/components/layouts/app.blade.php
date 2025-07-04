<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Título da Página --}}
    <title>{{ $title ?? 'Filtro de Produtos' }}</title>

    {{-- 
        Estou adicionando o Pico.css aqui para um estilo visual limpo e moderno.
        Ele estiliza os elementos HTML padrão sem a necessidade de classes.        
    --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"/>

    {{-- Estilos essenciais do Livewire --}}
    @livewireStyles
</head>
<body>
    {{-- Conteúdo principal da aplicação --}}
    <main class="container">
        {{-- O conteúdo do seu componente Livewire será injetado aqui na variável $slot --}}
        {{ $slot }}
    </main>

    {{-- Scripts essenciais do Livewire --}}
    @livewireScripts
</body>
</html>