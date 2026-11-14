@extends('admin.layout')

@section('directory')
    Workspace > Manage Rooms
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <x-room-availability-modal />

    <div class="flex flex-col gap-4 pl-2 sm:flex-row sm:items-center">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Manage Rooms</h3>
            <p class="mt-1 text-sm text-gray-500">Find rooms across colleges and check their current availability.</p>
        </div>
        <a href="{{ route('admin.colleges.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800 sm:ml-auto">
            Browse Colleges
        </a>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-2 text-xs text-gray-600">
        <span class="h-3 w-3 rounded-sm bg-red-100/40 ring-1 ring-red-200/60" aria-hidden="true"></span>
        Red rows mean the room is excluded from availability.
    </div>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
        @foreach ([
            ['label' => 'Total Rooms', 'value' => $stats['total']],
            ['label' => 'Free', 'value' => $stats['free']],
            ['label' => 'Occupied', 'value' => $stats['occupied']],
            ['label' => 'Disabled', 'value' => $stats['disabled']],
        ] as $card)
            <div class="rounded-lg border border-gray-200 bg-white px-5 py-4">
                <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-bold {{ $card['label'] === 'Disabled' ? 'text-red-700' : 'text-gray-900' }}">
                    {{ $card['value'] }}
                </p>
            </div>
        @endforeach
    </div>

    <div class="rounded-lg border border-gray-200 bg-white">
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="flex flex-col gap-3 border-b border-gray-200 p-4 sm:flex-row">
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search rooms, buildings, or colleges"
                class="min-w-0 flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
            >
            <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All statuses</option>
                <option value="free" {{ $status === 'free' ? 'selected' : '' }}>Free</option>
                <option value="occupied" {{ $status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="disabled" {{ $status === 'disabled' ? 'selected' : '' }}>Disabled</option>
            </select>
            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-blue-500">
                Filter
            </button>
            @if ($search !== '' || $status !== 'all')
                <a href="{{ route('admin.rooms.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50">
                    Clear
                </a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-wider text-gray-600">
                        <th class="px-6 py-3.5">Room</th>
                        <th class="px-6 py-3.5">College</th>
                        <th class="px-6 py-3.5">Building</th>
                        <th class="px-6 py-3.5">Floor</th>
                        <th class="px-6 py-3.5">Type</th>
                        <th class="px-6 py-3.5">Availability</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                    @forelse ($filteredRooms as $row)
                        <tr class="{{ $row['status'] === 'Disabled' ? 'bg-red-100/40 hover:bg-red-50/40' : 'hover:bg-gray-50' }} transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-900">{{ $row['room']->code }}</span>
                                <span class="block text-xs text-gray-500">{{ $row['room']->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-900">{{ $row['college']->code }}</span>
                                <span class="block text-xs text-gray-500">{{ $row['college']->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-900">{{ $row['building']->code }}</span>
                                <span class="block text-xs text-gray-500">{{ $row['building']->name }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $row['floor']->name }}</td>
                            <td class="px-6 py-4">{{ $row['room']->room_type }}</td>
                            <td class="px-6 py-4">
                                @if ($row['status'] === 'Free')
                                    <span class="inline-flex items-center rounded-md bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Free</span>
                                @elseif ($row['status'] === 'Occupied')
                                    <span class="inline-flex items-center rounded-md bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Occupied</span>
                                @else
                                    <span class="text-gray-400">&mdash;</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.buildings.show', $row['building']->id) }}" class="inline-flex items-center rounded-sm px-3 py-2 text-xs font-semibold text-blue-700 transition-colors hover:bg-blue-50">
                                        Building
                                    </a>
                                    <form action="{{ route('admin.rooms.availability', $row['room']->id) }}" method="POST"
                                        data-action="{{ $row['room']->for_use ? 'disable' : 'enable' }}"
                                        onsubmit="event.preventDefault(); openRoomAvailabilityModal(this);">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="inline-flex items-center rounded-sm px-3 py-2 text-xs font-semibold transition-colors {{ $row['room']->for_use ? 'text-rose-700 hover:bg-rose-50' : 'text-emerald-700 hover:bg-emerald-50' }}">
                                            {{ $row['room']->for_use ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <p class="font-medium text-gray-700">
                                    {{ $stats['total'] === 0 ? 'No rooms have been added yet.' : 'No rooms match these filters.' }}
                                </p>
                                @if ($stats['total'] > 0 && ($search !== '' || $status !== 'all'))
                                    <a href="{{ route('admin.rooms.index') }}" class="mt-2 inline-flex text-sm font-semibold text-blue-700 hover:text-blue-800">
                                        Clear filters
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
