@extends('admin.layout')

@section('directory')
    Workspace > Manage Buildings
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex pl-2 gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Manage Buildings</h3>
            <p class="text-sm text-gray-500 mt-1">View building details and room availability.</p>
        </div>
        <a href="{{ route('admin.buildings.create') }}" class="ml-auto mt-auto">
            <button class="flex px-3.5 py-2.5 text-xs font-semibold items-center gap-2 bg-blue-600 hover:bg-blue-500 active:bg-blue-400 text-white transition-colors duration-150 rounded-lg shadow-sm"> 
                + Add New Building
            </button>
        </a>
    </div>

    <x-delete-modal />

    <div class="bg-white rounded-lg border border-gray-200">
        <div class="flex flex-wrap items-center justify-end gap-2 border-b border-gray-200 px-6 py-3 text-xs text-gray-600">
            <span class="h-3 w-3 rounded-sm bg-red-100/40 ring-1 ring-red-200/60" aria-hidden="true"></span>
            <span>Red rows have availability disabled.</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-600">
                        <th class="py-3.5 px-6">College</th>
                        <th class="py-3.5 px-6">Abbreviation</th>
                        <th class="w-[28rem] min-w-[20rem] py-3.5 px-6">Building Name</th>
                        <th class="py-3.5 px-6">Total Rooms</th>
                        <th class="py-3.5 px-6">Free</th>
                        <th class="py-3.5 px-6">Occupied</th>
                        <th class="py-3.5 px-6">Disabled</th>
                        <th class="py-3.5 px-6 text-right w-1 whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
            
                <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                    @forelse ($buildings as $building)
                        @php
                            $rooms = $building->floors->flatMap(fn ($floor) => $floor->rooms);
                            $availabilityEnabled = $building->is_active && $building->college->is_active;
                            $usableRooms = $availabilityEnabled ? $rooms->where('for_use', true) : collect();
                            $freeRooms = $usableRooms->where('is_available', true)->count();
                            $occupiedRooms = $usableRooms->where('is_available', false)->count();
                            $disabledRooms = $rooms->count() - $freeRooms - $occupiedRooms;
                        @endphp
                        <tr class="{{ $availabilityEnabled ? 'hover:bg-gray-50' : 'bg-red-100/40 hover:bg-red-50/40' }} transition-colors">
                            <td class="py-4 px-6 font-bold text-gray-900">
                                <span class="inline-block bg-gray-100 text-gray-800 px-2.5 py-1 rounded-md border border-gray-200">
                                    {{ $building->college->code }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-900 font-semibold">
                                {{ $building->code }}
                            </td>
                            <td class="min-w-[20rem] py-4 px-6">
                                <span class="block whitespace-normal break-words font-semibold leading-5 text-gray-900">{{ $building->name }}</span>
                            </td>
                            <td class="py-4 px-6">
                               {{ $rooms->count() }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-emerald-100 text-emerald-800 rounded-md">
                                    {{ $freeRooms }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-red-100 text-red-800 rounded-md">
                                    {{ $occupiedRooms }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-red-50 text-red-700 rounded-md">
                                    {{ $disabledRooms }}
                                </span>
                            </td>
                            <td class="py-4 px-6 w-1 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
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
                            <td colspan="8" class="py-4 text-center text-gray-600 font-light">
                                No buildings have been added yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection