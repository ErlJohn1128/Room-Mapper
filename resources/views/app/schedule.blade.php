@extends('layouts.mobile')

@section('title', 'My schedule')

@section('content')
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-800">Professor workspace</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight">My Schedule</h1>
        <p class="mt-1 text-sm text-slate-500">Release a scheduled room when you will be away.</p>
    </div>

    <div class="mb-5 rounded-2xl bg-blue-950 p-4 text-white">
        <p class="text-sm font-semibold">Taking leave?</p>
        <p class="mt-1 text-sm leading-5 text-blue-100">Add your dates once. Every assigned room will be free during its scheduled classes in this period.</p>
    </div>

    <form method="POST" action="{{ route('app.schedule.leave') }}" class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        @csrf
        <p class="mb-3 text-sm font-bold">Mark dates away</p>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="starts_on" class="mb-1 block text-xs font-medium text-slate-600">From</label>
                <input id="starts_on" type="date" name="starts_on" min="{{ today()->toDateString() }}" value="{{ old('starts_on') }}" required
                    class="w-full rounded-lg border border-slate-300 px-2.5 py-2.5 text-sm">
            </div>
            <div>
                <label for="ends_on" class="mb-1 block text-xs font-medium text-slate-600">Through</label>
                <input id="ends_on" type="date" name="ends_on" min="{{ today()->toDateString() }}" value="{{ old('ends_on') }}" required
                    class="w-full rounded-lg border border-slate-300 px-2.5 py-2.5 text-sm">
            </div>
        </div>
        @error('starts_on') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        @error('ends_on') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        <button type="submit" class="mt-3 w-full rounded-xl bg-blue-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-800">Free my scheduled rooms</button>
    </form>

    @if ($absences->isNotEmpty())
        <section class="mb-6">
            <h2 class="mb-2 text-sm font-bold">Upcoming leave</h2>
            <div class="space-y-2">
                @foreach ($absences as $absence)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                        <span class="text-sm font-medium text-emerald-900">{{ $absence->starts_on->format('M j') }} – {{ $absence->ends_on->format('M j, Y') }}</span>
                        <form method="POST" action="{{ route('app.schedule.leave.cancel', $absence->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-rose-700 underline decoration-rose-300 underline-offset-2">Undo</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <div class="space-y-4">
        @forelse ($assignments as $assignment)
            @php
                $room = $assignment->room;
                $floor = $room->floor;
                $building = $floor->building;
                $college = $building->college;
                $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            @endphp
            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-blue-800">
                                {{ $weekdays[$assignment->day_of_week] ?? 'Scheduled class' }}
                                · {{ \Carbon\Carbon::parse($assignment->start_time)->format('g:i A') }}–{{ \Carbon\Carbon::parse($assignment->end_time)->format('g:i A') }}
                            </p>
                            <h2 class="mt-2 text-base font-bold">{{ $room->name }}</h2>
                            <p class="mt-1 text-xs text-slate-500">{{ $room->code }} · {{ $building->name }} · {{ $floor->name }}</p>
                        </div>
                        <span class="rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600">{{ $assignment->semester }}</span>
                    </div>
                    <p class="mt-3 text-xs text-slate-500">{{ $college->name }} · {{ $assignment->school_year }}</p>
                </div>

            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 px-5 py-10 text-center">
                <p class="font-semibold text-slate-800">No rooms assigned yet</p>
                <p class="mt-1 text-sm text-slate-500">Your assigned rooms and class times will appear here.</p>
            </div>
        @endforelse
    </div>
@endsection
