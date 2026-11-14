@extends('admin.layout')

@section('directory')
    Workspace > Manage Buildings > Add Building
@endsection

@section('content')

@if (session('success'))
    <div id="toast-notification"
        role="status"
        aria-live="polite"
        aria-atomic="true"
        class="fixed flex justify-center items-center top-18 right-15 z-50 gap-2 rounded-lg bg-emerald-400/80 px-3 py-2 text-sm font-medium text-white shadow-lg transition-all duration-500"
    >
        <div class="flex items-center justify-center w-4 h-4">
            <img src="{{ asset('images/check-icon.svg') }}"/>
        </div>
        <span>
            {{ session('success') }}
        </span>
    </div>
@elseif (session('error'))
    <div id="toast-notification"
        role="status"
        aria-live="polite"
        aria-atomic="true"
        class="fixed flex justify-center items-center top-18 right-15 z-50 gap-2 rounded-lg bg-red-400/80 px-3 py-2 text-sm font-light text-white shadow-lg transition-all duration-500"
    >
        <div class="flex items-center justify-center w-4 h-4">
            <img src="{{ asset('images/close-icon.svg') }}"/>
        </div>
        <span>{{ session('Something went wrong') }}</span>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast-notification');

        if (toast) {
            // 1. Smoothly animate IN right after the page loads
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-x-8');
                toast.classList.add('opacity-100', 'translate-x-0');
            }, 50); // Small delay ensures the browser registers the CSS transition

            // 2. Smoothly animate OUT after 3 seconds
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-x-0');
                toast.classList.add('opacity-0', 'translate-x-8');
                
                // Remove from the page completely after the 500ms transition finishes
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    });
</script>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div>
        <a href="{{ route('admin.buildings.index') }}"
        class="text-gray-400 ">
            &larr; <span class="text-sm hover:underline">Back to Previous Page</span>
        </a>
        <h3 class="mt-2 text-2xl font-bold text-gray-800">Create a Building</h3>
        <p class="text-sm text-gray-500 mt-1">Assign a building to a college.</p>
    </div>

    <div class="rounded-md pb-5 bg-white">

       <div class="flex items-center rounded-lg px-7 pt-5 gap-3">
            <div class="flex items-center justify-center w-14 h-14 bg-emerald-100 rounded-4xl">
                <img src="{{ asset('images/college-icon.svg') }}" />
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Building Information</h3>
                <p class="text-sm text-gray-500">Enter the basic details for this building.</p>
            </div>
        </div>

        <div class="bg-white mt-4 px-8 mb-2">
            <hr class="my-3 border-gray-300">

            <form  
                method="POST" 
                action="{{ route('admin.buildings.store') }}" 
                class="flex flex-col gap-4"
            >
            @csrf

                <div class="flex flex-col gap-2">
                    <h5 class="text-md font-semibold text-gray-700">
                        Assigned College
                        <span class="text-red-700">&ast;</span>
                    </h5>
                    <select 
                        name="college_id"
                        class="w-full px-4 py-2 text-sm border border-gray-700 bg-white focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all cursor-pointer"
                        required
                    >
                        <option value="" disabled {{ old('college_id', request()->query('college_id')) ? '' : 'selected' }}>-- Select a College --</option>
                        @foreach ($colleges as $college)
                            <option value="{{ $college->id }}" {{ old('college_id', request()->query('college_id')) == $college->id ? 'selected' : '' }}>
                                {{ $college->code }} - {{ $college->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <h5 class="text-md font-semibold text-gray-700">
                        Building Name
                        <span class="text-red-700">&ast;</span>
                    </h5>
                    <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                        type="text"
                        placeholder="Enter Building Name"
                        name="name"
                        value="{{ old('name') }}"
                        maxlength="300"
                    />
                </div>

                <div class="flex justify-center gap-4">
                    <div class="flex flex-1 flex-col gap-2">
                        <h5 class="text-md font-semibold text-gray-700">
                            Building Code
                            <span class="text-red-700">&ast;</span>
                        </h5>
                        <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                            type="text"
                            placeholder="Enter Building Abbreviation (e.g Main, CICT Bldg., COS Bldg.)"
                            name="code"
                            value="{{ old('code') }}"
                            maxlength="50"
                        />
                    </div>

                    <div class="flex flex-1 flex-col gap-2">
                        <h5 class="text-md text-gray-700">
                            Building Number of Floors
                            <span class="text-red-700">&ast;</span>
                        </h5>
                        <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                            type="number"
                            value="{{ old('floors_count') }}"
                            name="floors_count"
                            maxlength="50"
                        />
                    </div>
                </div>

                <div class="flex flex-col justify-center gap-2">
                    <h3 class="text-gray-800 text-md font-semibold">
                        Operating Hours
                    </h3>
                    <div class="flex items-center gap-4">
                        <div class="flex flex-1 flex-col gap-2">
                            <h5 class="text-md text-gray-700">
                                Start Time
                                <span class="text-red-700">&ast;</span>
                            </h5>
                            <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                                type="time"
                                name="start_time"
                                value="{{ old('start_time', $building->start_time ?? '07:00') }}"
                                maxlength="50"
                            />
                        </div>
                        <div class="flex flex-1 flex-col gap-2">
                            <h5 class="text-md text-gray-700">
                                Closing Time
                                <span class="text-red-700">&ast;</span>
                            </h5>
                            <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                                type="time"
                                name="end_time"
                                value="{{ old('end_time', $building->end_time ?? '21:00') }}"
                                maxlength="50"
                            />
                        </div>
                    </div>
                </div>

                <hr class="my-2 border-gray-300">

                <div class="flex items-center justify-end gap-2.5">
                    <a href={{ route('admin.buildings.index') }} class="flex items-center justify-center px-6 py-2 rounded-md border border-gray-600 hover:bg-gray-100 active:bg-gray-200">
                        Cancel
                    </a>
                    <button class="flex items-center justify-center px-4 py-2 rounded-md border text-white bg-blue-500 border-blue-500 hover:bg-blue-400 active:bg-blue-300 transition-all">
                        Create Building
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection