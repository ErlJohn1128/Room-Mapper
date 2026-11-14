@extends('layouts.mobile')

@section('title', 'Find a classroom')

@section('content')
    <div class="mb-5">
        <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-800">Live availability</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight">Find a Classroom</h1>
        <p class="mt-1 text-sm text-slate-500">Check which rooms are free for your study session.</p>
    </div>

    <form method="GET" action="{{ route('app.rooms') }}" class="space-y-3">
        <div>
            <label for="search" class="sr-only">Search room or college</label>
            <input id="search" type="search" name="search" value="{{ $search }}" placeholder="Search room or college"
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-blue-700 focus:bg-white focus:ring-2 focus:ring-blue-100">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="date" class="mb-1 block text-xs font-semibold text-slate-600">Date</label>
                <input id="date" name="date" type="date" value="{{ $date }}" min="{{ today()->toDateString() }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm">
            </div>
            <div>
                <label for="time" class="mb-1 block text-xs font-semibold text-slate-600">Time</label>
                <input id="time" name="time" type="time" value="{{ $time }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm">
            </div>
        </div>
        <input type="hidden" name="status" value="{{ $status }}">
        <button type="submit" class="w-full rounded-xl bg-blue-900 px-4 py-3 text-sm font-bold text-white hover:bg-blue-800">Check availability</button>
    </form>

    <div class="mt-6 grid grid-cols-3 gap-2 rounded-xl bg-slate-100 p-1" role="group" aria-label="Filter by availability">
        @foreach (['free' => 'Free', 'occupied' => 'Occupied', 'all' => 'All rooms'] as $value => $label)
            <a href="{{ route('app.rooms', array_filter(['date' => $date, 'time' => $time, 'search' => $search, 'status' => $value !== 'all' ? $value : null])) }}"
                @class([
                    'rounded-lg px-2 py-2.5 text-center text-xs font-semibold transition',
                    'bg-white text-blue-900 shadow-sm' => $status === $value,
                    'text-slate-500 hover:text-slate-800' => $status !== $value,
                ])>
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="mt-5 flex items-center justify-between">
        <p class="text-sm font-semibold text-slate-800">{{ $filteredRooms->count() }} rooms found</p>
        <p class="text-xs text-slate-500">{{ $stats['free'] }} free</p>
    </div>

    <div class="mt-3 space-y-3">
        @forelse ($filteredRooms as $row)
            @php
                $room = $row['room'];
                $floor = $room->floor;
                $building = $floor->building;
                $college = $building->college;
            @endphp
            <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-semibold text-slate-500">{{ $college->name }}</p>
                        <h2 class="mt-1 text-base font-bold">{{ $room->name }}</h2>
                        <p class="mt-1 text-xs text-slate-500">{{ $building->code }} · {{ $floor->name }} · {{ $room->code }}</p>
                    </div>
                    <span @class([
                        'shrink-0 rounded-full px-3 py-1 text-xs font-bold',
                        'bg-emerald-100 text-emerald-800' => $row['is_free'],
                        'bg-rose-100 text-rose-800' => ! $row['is_free'],
                    ])>
                        {{ $row['is_free'] ? 'FREE' : 'OCCUPIED' }}
                    </span>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3">
                    <span class="text-xs text-slate-600">{{ $room->room_type }}</span>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 px-5 py-10 text-center">
                <p class="font-semibold text-slate-800">No rooms match those filters</p>
                <p class="mt-1 text-sm text-slate-500">Try another room name, date, or time.</p>
            </div>
        @endforelse
    </div>
@endsection
