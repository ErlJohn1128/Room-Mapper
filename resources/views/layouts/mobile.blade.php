<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Room Mapper') - Room Mapper</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="mx-auto min-h-screen max-w-lg bg-white shadow-sm">
        <header class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <a href="{{ route('app.home') }}" class="flex items-center gap-3" aria-label="Room Mapper home">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-900 text-lg font-bold text-white">R</span>
                <span>
                    <span class="block text-sm font-bold tracking-tight">Room Mapper</span>
                    <span class="block text-xs text-slate-500">Catanduanes State University</span>
                </span>
            </a>
            <span class="max-w-32 truncate rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold capitalize text-blue-900">
                {{ auth()->user()->role }}
            </span>
        </header>

        <main class="min-h-[calc(100vh-9rem)] px-5 pb-28 pt-6">
            @if (session('success'))
                <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>

        <nav aria-label="Main navigation" class="fixed inset-x-0 bottom-0 z-10 mx-auto grid max-w-lg border-t border-slate-200 bg-white px-2 pb-[max(env(safe-area-inset-bottom),0.5rem)] pt-2 shadow-[0_-8px_24px_rgba(15,23,42,0.06)]">
            @if (auth()->user()->role === 'professor')
                <div class="grid grid-cols-3">
                    <a href="{{ route('app.rooms') }}" class="flex flex-col items-center gap-1 py-2 text-xs font-medium {{ request()->routeIs('app.rooms') ? 'text-blue-900' : 'text-slate-500' }}">
                        <span class="text-lg" aria-hidden="true">⌕</span> Rooms
                    </a>
                    <a href="{{ route('app.schedule') }}" class="flex flex-col items-center gap-1 py-2 text-xs font-medium {{ request()->routeIs('app.schedule') ? 'text-blue-900' : 'text-slate-500' }}">
                        <span class="text-lg" aria-hidden="true">▦</span> Schedule
                    </a>
                    <a href="{{ route('app.settings') }}" class="flex flex-col items-center gap-1 py-2 text-xs font-medium {{ request()->routeIs('app.settings') ? 'text-blue-900' : 'text-slate-500' }}">
                        <span class="text-lg" aria-hidden="true">◉</span> Profile
                    </a>
                </div>
            @else
                <div class="grid grid-cols-3">
                    <a href="{{ route('app.home') }}" class="flex flex-col items-center gap-1 py-2 text-xs font-medium {{ request()->routeIs('app.home') ? 'text-blue-900' : 'text-slate-500' }}">
                        <span class="text-lg" aria-hidden="true">⌂</span> Home
                    </a>
                    <a href="{{ route('app.rooms') }}" class="flex flex-col items-center gap-1 py-2 text-xs font-medium {{ request()->routeIs('app.rooms') ? 'text-blue-900' : 'text-slate-500' }}">
                        <span class="text-lg" aria-hidden="true">⌕</span> Rooms
                    </a>
                    <a href="{{ route('app.settings') }}" class="flex flex-col items-center gap-1 py-2 text-xs font-medium {{ request()->routeIs('app.settings') ? 'text-blue-900' : 'text-slate-500' }}">
                        <span class="text-lg" aria-hidden="true">◉</span> Settings
                    </a>
                </div>
            @endif
        </nav>
    </div>
</body>
</html>
