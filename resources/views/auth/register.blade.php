<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account - Room Mapper</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="mx-auto flex min-h-screen max-w-lg flex-col justify-center px-6 py-10">
        <div class="mb-7 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-900 text-2xl font-bold text-white">R</div>
            <h1 class="text-3xl font-bold tracking-tight">Create your account</h1>
            <p class="mt-2 text-sm text-slate-500">Join Room Mapper as a student or professor.</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            @csrf
            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold">Full name</label>
                <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-100">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-100">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <fieldset>
                <legend class="mb-2 text-sm font-semibold">I am a</legend>
                <div class="grid grid-cols-2 gap-3">
                    @foreach (['student' => 'Student', 'professor' => 'Professor'] as $value => $label)
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-3 text-sm font-medium has-[:checked]:border-blue-700 has-[:checked]:bg-blue-50">
                            <input type="radio" name="role" value="{{ $value }}" @checked(old('role', 'student') === $value) class="text-blue-800 focus:ring-blue-700">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>
            <div>
                <label for="password" class="mb-1.5 block text-sm font-semibold">Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-100">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-100">
            </div>
            <button type="submit" class="w-full rounded-xl bg-blue-900 px-4 py-3.5 text-sm font-bold text-white transition hover:bg-blue-800">Create account</button>
            <p class="text-center text-sm text-slate-500">
                Already have an account? <a href="{{ route('login') }}" class="font-semibold text-blue-800">Sign in</a>
            </p>
        </form>
    </main>
</body>
</html>
