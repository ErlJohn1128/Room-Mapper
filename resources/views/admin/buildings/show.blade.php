@extends('admin.layout')

@section('directory')
    Workspace > Manage Building > {{ $building->code }}
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <x-disable-building-modal :building="$building" />

    <div class="flex pl-2 gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Manage {{ $building->code }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $building->college->code }} - {{ $building->name }} - Manage floors and room availability.</p>
        </div>
        <form action="{{ route('admin.buildings.availability', $building->id) }}" method="POST"
            data-action="{{ $building->is_active ? 'disable' : 'enable' }}"
            data-building-code="{{ $building->code }}"
            onsubmit="event.preventDefault(); openDisableBuildingModal(this);"
            class="ml-auto mt-auto">
            @csrf
            @method('PUT')

            <button type="submit" class="flex px-3.5 py-2.5 text-xs font-semibold items-center gap-2 text-white transition-colors duration-150 rounded-sm shadow-sm {{ $building->is_active ? 'bg-red-500 hover:bg-red-400 active:bg-red-300' : 'bg-emerald-600 hover:bg-emerald-500' }}">
                {{ $building->is_active ? 'Disable Building Availability' : 'Enable Building Availability' }}
            </button>
        </form>
    </div>

    <div id="rooms" class="bg-white rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800">Manage Floors</h4>
            <div class="mt-1 flex flex-wrap items-center justify-between gap-2">
                <p class="text-sm text-gray-500">Room counts and availability by floor.</p>
                <span class="inline-flex items-center gap-2 text-xs text-gray-600">
                    <span class="h-3 w-3 rounded-sm bg-red-100/40 ring-1 ring-red-200/60" aria-hidden="true"></span>
                    Red room markers mean availability is disabled.
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-600">
                        <th class="py-3.5 px-6">Floor</th>
                        <th class="py-3.5 px-6">Total Rooms</th>
                        <th class="py-3.5 px-6">Free</th>
                        <th class="py-3.5 px-6">Occupied</th>
                        <th class="py-3.5 px-6">Disabled</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                    @forelse ($building->floors->sortBy('id') as $floor)
                        @php
                            $parentAvailabilityEnabled = $building->is_active && $building->college->is_active;
                            $freeRoomList = $parentAvailabilityEnabled
                                ? $floor->rooms->where('for_use', true)->where('is_available', true)->sortBy('name')
                                : collect();
                            $occupiedRoomList = $parentAvailabilityEnabled
                                ? $floor->rooms->where('for_use', true)->where('is_available', false)->sortBy('name')
                                : collect();
                            $disabledRoomList = $floor->rooms->filter(fn ($room) => ! $parentAvailabilityEnabled || ! $room->for_use)->sortBy('name');
                            $totalRooms = $floor->rooms->count();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6 font-bold text-gray-900">
                                <span class="inline-block bg-gray-100 text-gray-800 px-2.5 py-1 rounded-md border border-gray-200">
                                    {{ $floor->name }}
                                </span>
                            </td>
                            <td class="py-4 px-6">{{ $totalRooms }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-emerald-100 text-emerald-800 rounded-md">
                                    {{ $freeRoomList->count() }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-red-100 text-red-800 rounded-md">
                                    {{ $occupiedRoomList->count() }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-red-50 text-red-700 rounded-md">
                                    {{ $disabledRoomList->count() }}
                                </span>
                            </td>
                        </tr>
                        <tr class="bg-gray-50/50">
                            <td colspan="5" class="px-6 py-4">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                                    <section class="rounded-sm border border-emerald-100 bg-emerald-50/40 p-4">
                                        <div class="mb-3 flex items-center gap-2 border-b border-emerald-100 pb-2">
                                            <h5 class="text-sm font-semibold text-emerald-800">Free rooms</h5>
                                            <span class="text-xs text-gray-500">{{ $freeRoomList->count() }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($freeRoomList as $room)
                                                <span class="inline-flex items-center gap-1.5 rounded-sm border border-emerald-100 bg-white/70 px-3 py-1.5 text-xs text-emerald-900">
                                                    <span class="font-semibold">{{ $room->code }}</span>
                                                    <span>{{ $room->name }}</span>
                                                </span>
                                            @empty
                                                <p class="text-sm text-gray-500">No free rooms on this floor.</p>
                                            @endforelse
                                        </div>
                                    </section>

                                    <section class="rounded-sm border border-red-100 bg-red-50/40 p-4">
                                        <div class="mb-3 flex items-center gap-2 border-b border-red-100 pb-2">
                                            <h5 class="text-sm font-semibold text-red-800">Occupied rooms</h5>
                                            <span class="text-xs text-gray-500">{{ $occupiedRoomList->count() }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($occupiedRoomList as $room)
                                                <span class="inline-flex items-center gap-1.5 rounded-sm border border-red-100 bg-white/70 px-3 py-1.5 text-xs text-red-900">
                                                    <span class="font-semibold">{{ $room->code }}</span>
                                                    <span>{{ $room->name }}</span>
                                                </span>
                                            @empty
                                                <p class="text-sm text-gray-500">No occupied rooms on this floor.</p>
                                            @endforelse
                                        </div>
                                    </section>

                                    <section class="rounded-sm border border-red-100 bg-red-50/25 p-4">
                                        <div class="mb-3 flex items-center gap-2 border-b border-red-100 pb-2">
                                            <h5 class="text-sm font-semibold text-gray-700">Disabled rooms</h5>
                                            <span class="text-xs text-gray-500">{{ $disabledRoomList->count() }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($disabledRoomList as $room)
                                                <span class="inline-flex items-center gap-1.5 rounded-sm border border-red-100 bg-white/70 px-3 py-1.5 text-xs text-red-800">
                                                    <span class="font-semibold">{{ $room->code }}</span>
                                                    <span>{{ $room->name }}</span>
                                                </span>
                                            @empty
                                                <p class="text-sm text-gray-500">No disabled rooms on this floor.</p>
                                            @endforelse
                                        </div>
                                    </section>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-600 font-light">
                                No floors have been added to this building yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection