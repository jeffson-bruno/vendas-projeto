<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            /* Esconde elementos indesejados na impressão */
            .print-hidden {
                display: none !important;
            }

            /* Redefinir margens e padding */
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            /* Certificar que o conteúdo ocupe 100% da largura */
            .container {
                max-width: 100%;
                width: 100%;
            }

            /* Definir um tamanho adequado para a nota fiscal */
            @page {
                size: 80mm auto; /* Exemplo de tamanho de nota fiscal */
                margin: 5mm;
            }

            /* Ajustar o botão de impressão */
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>

