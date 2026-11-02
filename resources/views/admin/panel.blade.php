<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
   
    <div class="bg-blue-100 min-h-screen flex">
        <nav class="bg-white w-75">
            Nav
        </nav>

        <div class="flex-1">
            <header class="bg-gray-100 top-0 left-75 h-14">
                Header
            </header>
            <main>
                Main
            </main>
        </div>
        
    
    </div>

</body>
</html>
