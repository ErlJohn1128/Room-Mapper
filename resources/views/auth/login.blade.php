<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in - Room Mapper</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="mx-auto flex min-h-screen max-w-lg flex-col justify-center px-6 py-10">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-900 text-2xl font-bold text-white">R</div>
            <p class="text-sm font-semibold text-blue-800">Catanduanes State University</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight">Room Mapper</h1>
            <p class="mt-2 text-sm text-slate-500">Find a classroom or manage your teaching schedule.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            @csrf
            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-100">
                @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="mb-1.5 block text-sm font-semibold">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-100">
                @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input name="remember" type="checkbox" value="1" class="rounded border-slate-300 text-blue-800 focus:ring-blue-700">
                Remember me
            </label>
            <button type="submit" class="w-full rounded-xl bg-blue-900 px-4 py-3.5 text-sm font-bold text-white transition hover:bg-blue-800">Sign in</button>
            <p class="text-center text-sm text-slate-500">
                New here? <a href="{{ route('register') }}" class="font-semibold text-blue-800">Create an account</a>
            </p>
        </form>
    </main>
</body>
</html>
