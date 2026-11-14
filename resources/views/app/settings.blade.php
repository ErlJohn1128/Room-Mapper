@extends('layouts.mobile')

@section('title', 'Settings')

@section('content')
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-800">Your account</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight">Profile & Settings</h1>
    </div>

    <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-lg font-bold text-blue-900">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            <div class="min-w-0">
                <p class="truncate font-bold">{{ $user->name }}</p>
                <p class="truncate text-sm text-slate-500">{{ $user->email }}</p>
            </div>
        </div>
        <div class="mt-5 border-t border-slate-100 pt-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Account type</p>
            <p class="mt-1 text-sm font-semibold capitalize">{{ $user->role }}</p>
        </div>
    </section>

    <form method="POST" action="{{ route('logout') }}" class="mt-5">
        @csrf
        <button type="submit" class="w-full rounded-xl border border-rose-200 bg-white px-4 py-3 text-sm font-bold text-rose-700 transition hover:bg-rose-50">Sign out</button>
    </form>
@endsection
