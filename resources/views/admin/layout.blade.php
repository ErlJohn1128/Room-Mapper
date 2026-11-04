<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
   
    <div class="bg-blue-100 min-h-screen flex">
        <nav class="bg-white w-75">
            <div class="py-6 px-8 flex gap-4">
                <div class="w-12 h-12 rounded-md bg-gray-300 text-2xl font-bold flex justify-center items-center">
                    L
                </div>
                <div>
                    <strong class="font-semibold">CatSU</strong>
                    <p class="font-light text-sm">Room Mapper</p>
                </div>
            </div>
            <div class="px-5 font-semibold select-none transition-all ease-in-out">
                @yield('navigation')
            </div>
        </nav>

        <div class="flex-1">
            <header class="bg-gray-100 top-0 left-75 h-14">
                Header
            </header>
            <main>
                @yield('content')
            </main>
        </div>
        
    
    </div>

</body>
</html>