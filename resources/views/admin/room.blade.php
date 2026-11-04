@extends('admin.layout')

@section('navigation')
    <p class="text-xs text-gray-600 ml-3 mb-3 mt-4">
        WORKSPACE
    </p>

    <div class="text-sm flex flex-col gap-1 px-4">
        <!-- Overview -->
        <a href="{{ route('admin.overview.index') }}"
        class="pl-4 py-2.5 flex items-center gap-2 rounded-sm transition-colors hover:bg-gray-200">
            <img class="w-4.5" src="{{ asset('images/overview-icon.svg') }}" alt="Overview">
            Overview
        </a>

        <!-- Manage Colleges -->
        <a 
        class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors hover:bg-gray-200">
            <img class="w-4.5" src="{{ asset('images/college-icon.svg') }}" alt="Colleges">
            Manage Colleges
        </a>

        <!-- Manage Buildings -->
        <a href="{{ route('admin.buildings.index') }}"
        class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors hover:bg-gray-200">
            <img class="w-4.5" src="{{ asset('images/building-icon.svg') }}" alt="Buildings">
            Manage Buildings
        </a>

        <!-- Room -->
        <a href="{{ route('admin.rooms.index') }}"
        class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold border-l-2 border-emerald-700">
            <img class="w-4.5" src="{{ asset('images/room-icon.svg') }}" alt="Room">
            Room
        </a>
    </div>

    <p class="text-xs text-gray-600 ml-3 mb-3 mt-4">
        PREFERENCES
    </p>

    <div class="text-sm flex flex-col gap-1 px-4">
        <!-- Setting -->
        <a 
        class="pl-4 py-3 flex items-center gap-2 rounded-sm transition-colors hover:bg-gray-200">
            <img class="w-4.5" src="{{ asset('images/setting-icon.svg') }}" alt="Room">
            Settings
        </a>
    </div>
@endsection

@section('content')
@endsection