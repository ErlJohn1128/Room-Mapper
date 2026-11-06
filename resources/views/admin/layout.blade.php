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
            <div class="px-5 font-semibold select-none transition-all duration-200 ease-in-out">
                <p class="text-xs text-gray-600 ml-3 mb-3 mt-4">
                    WORKSPACE
                </p>

                <div class="text-sm flex flex-col gap-1 px-4">
                    <!-- Overview -->
                    <a href="{{ route('admin.overview.index') }}"
                    class="pl-4 py-2.5 flex items-center gap-2 rounded-sm transition-colors {{ request()->routeIs('admin.overview.*') ? 'bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold border-l-2 border-emerald-700' : 'hover:bg-gray-200' }}">
                        <img class="w-4.5" src="{{ asset('images/overview-icon.svg') }}" alt="Overview">
                        Overview
                    </a>

                    <!-- Manage Colleges -->
                    <a href="{{ route('admin.colleges.index') }}"
                    class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors {{ request()->routeIs('admin.colleges.*') ? 'bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold border-l-2 border-emerald-700' : 'hover:bg-gray-200' }}">
                        <img class="w-4.5" src="{{ asset('images/college-icon.svg') }}" alt="Colleges">
                        Manage Colleges
                    </a>

                    <!-- Manage Buildings -->
                    <a href="{{ route('admin.buildings.index') }}"
                    class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors {{ request()->routeIs('admin.buildings.*') ? 'bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold border-l-2 border-emerald-700' : 'hover:bg-gray-200' }}">
                        <img class="w-4.5" src="{{ asset('images/building-icon.svg') }}" alt="Buildings">
                        Manage Buildings
                    </a>

                    <!-- Room -->
                    <a href="{{ route('admin.rooms.index') }}"
                    class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors {{ request()->routeIs('admin.rooms.*') ? 'bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold border-l-2 border-emerald-700' : 'hover:bg-gray-200' }}">
                        <img class="w-4.5" src="{{ asset('images/room-icon.svg') }}" alt="Room">
                        Room
                    </a>
                </div>

                <p class="text-xs text-gray-600 ml-3 mb-3 mt-4">
                    PREFERENCES
                </p>

                <div class="text-sm flex flex-col gap-1 px-4">
                    <!-- Setting -->
                    <a href="{{ route('admin.settings.index') }}"
                    class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold border-l-2 border-emerald-700' : 'hover:bg-gray-200' }}">
                        <img class="w-4.5" src="{{ asset('images/setting-icon.svg') }}" alt="Room">
                        Settings
                    </a>
                </div>
            </div>
        </nav>

        <div class="flex-1">
            <header class="flex bg-gray-100 top-0 left-75 h-14">
                <!-- Directory -->
                <div class="flex flex-1 justify-start items-center ml-8 text-gray-500">
                    @yield('directory')
                </div>

                 <!-- Header Elements -->
                <div class="flex flex-1 gap-2.5 items-center justify-end mr-12">

                    <!-- Search Field -->
                    <div class="flex bg-gray-200 pl-2 py-2 gap-2 rounded-2xl">
                        <img class="w-4.5" src="{{ asset('images/search-icon.svg') }}" />
                        <input type="text" placeholder="Search" 
                            class="text-sm focus:outline-none "
                        />
                    </div>

                    <!-- Notification -->
                    <div class="w-8 h-8 transition-all duration-200 ease-in-out flex justify-center items-center rounded-2xl hover:bg-gray-200 active:bg-gray-300">
                        <img src="{{ asset('images/notification-icon.svg') }}" />
                    </div>

                    <!-- Account Circle -->
                    <div class="flex justify-center items-center">
                        <div class="flex justify-center items-center font-semibold text-xs w-7 h-7 rounded-xl bg-emerald-200 text-emerald-600">EA</div>
                    </div>
                </div>
            </header>
            
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>