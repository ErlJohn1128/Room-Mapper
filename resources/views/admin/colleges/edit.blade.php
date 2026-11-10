@extends('admin.layout')

@section('directory')
    Workspace > Manage Colleges > Edit College
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div>
        <a href="{{ route('admin.colleges.index') }}"
        class="text-gray-400 ">
            &larr; <span class="text-sm hover:underline">Back to Previous Page</span>
        </a>
        <h3 class="mt-2 text-2xl font-bold text-gray-800">Edit College</h3>
        <p class="text-sm text-gray-500 mt-1">Tweak the college information.</p>
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

            <form class="flex flex-col gap-4">
            @csrf
                <div class="flex flex-col gap-2">
                    <h5 class="text-md font-semibold text-gray-700">
                        College Name
                        <span class="text-red-700">&ast;</span>
                    </h5>
                    <input class="w-full px-4 py-2 text-sm border border-gray-700 focus:outline-none focus:border-gray-400 focus:ring-4 focus:ring-gray-100 transition-all"
                        type="text"
                        placeholder="Enter College Name"
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
                    />
                </div>

                <hr class="my-2 border-gray-300">

                <div class="flex items-center justify-end gap-2.5">
                    <a href={{ route('admin.colleges.index') }} class="flex items-center justify-center px-6 py-2 rounded-md border border-gray-600 hover:bg-gray-100 active:bg-gray-200">
                        Cancel
                    </a>
                    <button class="flex items-center justify-center px-4 py-2 rounded-md border text-white bg-blue-500 border-blue-500 hover:bg-blue-400 active:bg-blue-300 transition-all">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection