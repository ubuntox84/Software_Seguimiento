<html class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

</head>

<body class=" h-full ">
    <div class="min-h-full bg-white py-16 px-6 sm:py-24 md:grid md:place-items-center lg:px-8 ">
        <div class="mx-auto max-w-max">
            <main class="sm:flex">
                <p class="text-4xl font-bold tracking-tight text-indigo-600 sm:text-5xl">403</p>
                <div class="sm:ml-6">
                    <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-xl">EL USUARIO NO TIENE LOS ROLES ADECUADOS.</h1>
                       
                    </div>
                    <div class="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                           Volver a Inicio</a>
                        <a href="#"
                            class="inline-flex items-center rounded-md border border-transparent bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Pongase en contacto con soporte</a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>