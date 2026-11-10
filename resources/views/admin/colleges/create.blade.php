@extends('admin.layout')

@section('directory')
    Workspace > Manage Colleges > Add College
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
        <a href="{{ route('admin.colleges.index') }}"
        class="text-gray-400 ">
            &larr; <span class="text-sm hover:underline">Back to Previous Page</span>
        </a>
        <h3 class="mt-2 text-2xl font-bold text-gray-800">Create a college</h3>
        <p class="text-sm text-gray-500 mt-1">Add a college to the campus.</p>
    </div>

    <div class="rounded-md pb-5 bg-white">

       <div class="flex items-center rounded-lg px-7 pt-5 gap-3">
            <div class="flex items-center justify-center w-14 h-14 bg-emerald-100 rounded-4xl">
                <img src="{{ asset('images/college-icon.svg') }}" />
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">College Information</h3>
                <p class="text-sm text-gray-500">Enter the basic details for this college.</p>
            </div>
        </div>

        <div class="bg-white mt-4 px-8 mb-2">
            <hr class="my-3 border-gray-300">

            <form  
                method="POST" 
                action="{{ route('admin.colleges.store') }}" 
                class="flex flex-col gap-4"
            >
            @csrf
            
                <div class="flex flex-col gap-2">
                    <h5 class="text-md font-semibold text-gray-700">
                        College Name
                        <span class="text-red-700">&ast;</span>
                    </h5>
                    <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                        type="text"
                        placeholder="Enter College Name"
                        name="name"
                        maxlength="300"
                    />
                </div>

                <div class="flex flex-col gap-2">
                    <h5 class="text-md font-semibold text-gray-700">
                        College Code
                        <span class="text-red-700">&ast;</span>
                    </h5>
                    <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                        type="text"
                        placeholder="Enter College Abbreviation (e.g CICT, COS)"
                        name="code"
                        maxlength="50"
                    />
                </div>

                <hr class="my-2 border-gray-300">

                <div class="flex items-center justify-end gap-2.5">
                    <a href={{ route('admin.colleges.index') }} class="flex items-center justify-center px-6 py-2 rounded-md border border-gray-600 hover:bg-gray-100 active:bg-gray-200">
                        Cancel
                    </a>
                    <button class="flex items-center justify-center px-4 py-2 rounded-md border text-white bg-blue-500 border-blue-500 hover:bg-blue-400 active:bg-blue-300 transition-all">
                        Create College
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection