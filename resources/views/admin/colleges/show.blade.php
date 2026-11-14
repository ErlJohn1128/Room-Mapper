@extends('admin.layout')

@section('directory')
    Workspace > Manage Colleges > {{ $college->code }}
@endsection

@section('content')
@php
    $buildings = $college->buildings->sortBy('name');
    $totalFloors = $buildings->sum(fn ($building) => $building->floors->count());
    $rooms = $buildings->flatMap(fn ($building) => $building->floors->flatMap(fn ($floor) => $floor->rooms));
    $usableRooms = $college->is_active
        ? $buildings->where('is_active', true)->flatMap(fn ($building) => $building->floors->flatMap(fn ($floor) => $floor->rooms))->where('for_use', true)
        : collect();
    $freeRooms = $usableRooms->where('is_available', true)->count();
    $occupiedRooms = $usableRooms->where('is_available', false)->count();
    $disabledRooms = $rooms->count() - $freeRooms - $occupiedRooms;
    $summaryCards = [
        ['label' => 'Buildings', 'value' => $buildings->count()],
        ['label' => 'Floors', 'value' => $totalFloors],
        ['label' => 'Total Rooms', 'value' => $rooms->count()],
        ['label' => 'Free Rooms', 'value' => $freeRooms],
        ['label' => 'Occupied Rooms', 'value' => $occupiedRooms],
        ['label' => 'Disabled Rooms', 'value' => $disabledRooms],
    ];
@endphp

<div class="max-w-7xl mx-auto space-y-6">
    <x-college-availability-modal :college="$college" />
    <x-delete-modal />

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $college->name }}</h3>
            <p class="mt-1 text-sm text-gray-500">College overview, buildings, and room availability.</p>
        </div>

        <div class="flex flex-wrap gap-2 sm:ml-auto">
            <a href="{{ route('admin.colleges.edit', $college->id) }}"
                class="inline-flex items-center rounded-md border border-gray-300 px-3.5 py-2.5 text-xs font-semibold text-gray-700 transition-colors hover:bg-gray-50">
                Edit College
            </a>
            <form action="{{ route('admin.colleges.availability', $college->id) }}" method="POST"
                onsubmit="event.preventDefault(); openCollegeAvailabilityModal(this);">
                @csrf
                @method('PUT')
                <button type="submit" class="inline-flex items-center rounded-md px-3.5 py-2.5 text-xs font-semibold text-white shadow-sm transition-colors {{ $college->is_active ? 'bg-red-500 hover:bg-red-400' : 'bg-emerald-600 hover:bg-emerald-500' }}">
                    {{ $college->is_active ? 'Disable Availability' : 'Enable Availability' }}
                </button>
            </form>
            <a href="{{ route('admin.buildings.create', ['college_id' => $college->id]) }}"
                class="inline-flex items-center rounded-md bg-blue-600 px-3.5 py-2.5 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-blue-500">
                + Add Building
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-6">
        @foreach ($summaryCards as $card)
            <div class="rounded-sm border border-gray-200 bg-white px-5 py-4">
                <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-bold {{ $card['label'] === 'Disabled Rooms' ? 'text-red-700' : 'text-gray-900' }}">
                    {{ $card['value'] }}
                </p>
            </div>
        @endforeach
    </div>

    <div id="buildings" class="rounded-md border border-gray-200 bg-white">
        <div class="flex flex-col gap-1 border-b border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h4 class="text-md font-semibold text-gray-800">Buildings</h4>
                <p class="text-sm text-gray-500">Manage this college's buildings and see room availability.</p>
            </div>
            <span class="inline-flex items-center gap-2 text-xs text-gray-600">
                <span class="h-3 w-3 rounded-sm bg-red-50 ring-1 ring-red-200/60" aria-hidden="true"></span>
                Red rows have availability disabled.
            </span>
            
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-wider text-gray-600">
                        <th class="w-[28rem] min-w-[20rem] px-6 py-3.5">Building</th>
                        <th class="px-6 py-3.5">Floors</th>
                        <th class="px-6 py-3.5">Total Rooms</th>
                        <th class="px-6 py-3.5">Free</th>
                        <th class="px-6 py-3.5">Occupied</th>
                        <th class="px-6 py-3.5">Disabled</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                    @forelse ($buildings as $building)
                        @php
                            $buildingRooms = $building->floors->flatMap(fn ($floor) => $floor->rooms);
                            $buildingAvailabilityEnabled = $college->is_active && $building->is_active;
                            $usableBuildingRooms = $buildingAvailabilityEnabled ? $buildingRooms->where('for_use', true) : collect();
                            $buildingFreeRooms = $usableBuildingRooms->where('is_available', true)->count();
                            $buildingOccupiedRooms = $usableBuildingRooms->where('is_available', false)->count();
                            $buildingDisabledRooms = $buildingRooms->count() - $buildingFreeRooms - $buildingOccupiedRooms;
                        @endphp
                        <tr class="{{ $buildingAvailabilityEnabled ? 'hover:bg-gray-50' : 'bg-red-50 hover:bg-red-100/40' }} transition-colors">
                            <td class="min-w-[20rem] px-6 py-4">
                                <a href="{{ route('admin.buildings.show', $building->id) }}" class="block min-w-0">
                                    <span class="inline-block rounded-md border border-gray-200 bg-gray-100 px-2.5 py-1 font-bold text-gray-800">
                                        {{ $building->code }}
                                    </span>
                                    <span class="mt-1 block whitespace-normal break-words font-semibold leading-5 text-gray-900 hover:text-blue-700">
                                        {{ $building->name }}
                                    </span>
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $building->floors->count() }}</td>
                            <td class="px-6 py-4">{{ $buildingRooms->count() }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                    {{ $buildingFreeRooms }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                    {{ $buildingOccupiedRooms }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                    {{ $buildingDisabledRooms }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5 whitespace-nowrap">
                                    <a href="{{ route('admin.buildings.show', $building->id) }}"
                                        title="Manage Building" class="group relative inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition-colors hover:bg-blue-50 hover:text-blue-600">
                                        <img src="{{ asset('images/building-icon.svg') }}" alt="Building" class="block h-5 w-5 min-h-5 min-w-5 object-contain">
                                        <span class="pointer-events-none absolute right-0 top-full z-50 mt-2 hidden whitespace-nowrap rounded-md bg-gray-700/90 px-2.5 py-1 text-xs text-white shadow-md group-hover:block">
                                            Manage Building
                                        </span>
                                    </a>

                                    <a href="{{ route('admin.buildings.show', $building->id) }}#rooms"
                                        title="Manage Rooms" class="group relative inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition-colors hover:bg-blue-50 hover:text-blue-600">
                                        <img src="{{ asset('images/room-icon.svg') }}" alt="Room" class="block h-5 w-5 min-h-5 min-w-5 object-contain">
                                        <span class="pointer-events-none absolute right-0 top-full z-50 mt-2 hidden whitespace-nowrap rounded-md bg-gray-700/90 px-2.5 py-1 text-xs text-white shadow-md group-hover:block">
                                            Manage Rooms
                                        </span>
                                    </a>

                                    <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                        title="Edit Building" class="group relative inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition-colors hover:bg-amber-50 hover:text-amber-600">
                                        <img src="{{ asset('images/edit-icon.svg') }}" alt="Edit" class="block h-5 w-5 min-h-5 min-w-5 object-contain">
                                        <span class="pointer-events-none absolute right-0 top-full z-50 mt-2 hidden whitespace-nowrap rounded-md bg-gray-700/90 px-2.5 py-1 text-xs text-white shadow-md group-hover:block">
                                            Edit Building
                                        </span>
                                    </a>

                                    <form action="{{ route('admin.buildings.destroy', $building->id) }}" method="POST"
                                        data-delete-title="Delete this building?"
                                        data-delete-message="This permanently deletes this building and its floors and rooms. This action cannot be undone."
                                        data-delete-confirm="Delete Building"
                                        title="Delete Building"
                                        class="group relative inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition-colors hover:bg-rose-50 hover:text-rose-600"
                                        onsubmit="event.preventDefault(); openDeleteModal(this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="relative">
                                            <img src="{{ asset('images/delete-icon.svg') }}" alt="Delete" class="block h-5 w-5 min-h-5 min-w-5 object-contain">
                                        </button>
                                        <span class="pointer-events-none absolute right-0 top-full z-50 mt-2 hidden whitespace-nowrap rounded-md bg-gray-700/90 px-2.5 py-1 text-xs text-white shadow-md group-hover:block">
                                            Delete Building
                                        </span>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <p class="font-medium text-gray-700">No buildings in this college yet.</p>
                                <p class="mt-1 text-sm text-gray-500">Add a building to start organizing floors and rooms.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="rooms" class="rounded-lg border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-6 py-4">
            <h4 class="text-lg font-semibold text-gray-800">Manage Rooms</h4>
            <p class="mt-1 text-sm text-gray-500">Room inventory across this college's buildings and floors.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-wider text-gray-600">
                        <th class="px-6 py-3.5">Building</th>
                        <th class="px-6 py-3.5">Floor</th>
                        <th class="px-6 py-3.5">Room</th>
                        <th class="px-6 py-3.5">Type</th>
                        <th class="px-6 py-3.5">Availability</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                    @if ($rooms->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-600 font-light">
                                No rooms have been added to this college yet.
                            </td>
                        </tr>
                    @else
                        @foreach ($buildings as $building)
                            @foreach ($building->floors->sortBy('id') as $floor)
                                @foreach ($floor->rooms->sortBy('name') as $room)
                                    @php
                                        $roomIsDisabled = ! $college->is_active || ! $building->is_active || ! $room->for_use;
                                    @endphp
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-gray-900">{{ $building->code }}</span>
                                            <span class="block text-xs text-gray-500">{{ $building->name }}</span>
                                        </td>
                                        <td class="px-6 py-4">{{ $floor->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-gray-900">{{ $room->code }}</span>
                                            <span class="block text-xs text-gray-500">{{ $room->name }}</span>
                                        </td>
                                        <td class="px-6 py-4">{{ $room->room_type }}</td>
                                        <td class="px-6 py-4">
                                            @if ($roomIsDisabled)
                                                <span class="inline-flex items-center rounded-sm bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">Disabled</span>
                                            @elseif ($room->is_available)
                                                <span class="inline-flex items-center rounded-md bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Free</span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Occupied</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
