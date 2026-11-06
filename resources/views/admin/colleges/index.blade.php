@extends('admin.layout')

@section('directory')
    Workspace > Manage Colleges
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Header Section -->
    <div class="flex pl-2 gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Manage Colleges</h3>
            <p class="text-sm text-gray-500 mt-1">Overview over all Colleges and its corresponding status.</p>
        </div>
        <a href="{{ route('admin.colleges.create') }}" class="ml-auto mt-auto">
            <button class="flex px-3.5 py-2.5 text-xs font-semibold items-center gap-2 bg-blue-600 hover:bg-blue-500 active:bg-blue-400 text-white transition-colors duration-150 rounded-lg shadow-sm"> 
                + Add New College
            </button>
        </a>
    </div>

    <div class="bg-white rounded-lg border border-gray-200">
        <div class="overflow-x-visible">
            <table class="w-full text-left border-collapse">
                
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-600">
                        <th class="py-3.5 px-6">Abbreviation</th>
                        <th class="py-3.5 px-6">College Name</th>
                        <th class="py-3.5 px-6">Total Rooms</th>
                        <th class="py-3.5 px-6">Free</th>
                        <th class="py-3.5 px-6">Occupied</th>
                        <th class="py-3.5 px-6 text-right w-1 whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
            
                <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6 font-bold text-gray-900">
                            <span class="inline-block bg-gray-100 text-gray-800 px-2.5 py-1 rounded-md border border-gray-200">
                                CICT
                            </span>
                        </td>
                        <td class="py-4 px-6 text-gray-900 font-semibold">
                            College of Information and Communications Technology
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center text-xs font-semibold">
                                24
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-emerald-100 text-emerald-800 rounded-md">
                                12
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-red-100 text-red-800 rounded-md">
                                14
                            </span>
                        </td>
                        <td class="py-4 px-6 w-1 whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                           
                                <button title="Manage Buildings" class="group relative inline-flex items-center justify-center p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <img src="{{ asset('images/building-icon.svg') }}" alt="Building" class="w-5 h-5 min-w-5 min-h-5 object-contain block"/>
                                    <span class="pointer-events-none absolute top-full right-0 mt-2 hidden group-hover:block whitespace-nowrap rounded-md bg-gray-700/90 px-2.5 py-1 text-xs text-white shadow-md z-50">
                                        View Rooms
                                    </span>
                                </button>

                                <button title="Edit College" class="group relative inline-flex items-center justify-center p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <img src="{{ asset('images/edit-icon.svg') }}" alt="Edit" class="w-5 h-5 min-w-5 min-h-5 object-contain block"/>
                                    <span class="pointer-events-none absolute top-full right-0 mt-2 hidden group-hover:block whitespace-nowrap rounded-md bg-gray-700/90 px-2.5 py-1 text-xs text-white shadow-md z-50">
                                        Edit College
                                    </span>
                                </button>

                                <button title="Delete College" class="group relative inline-flex items-center justify-center p-2 text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                    <img src="{{ asset('images/delete-icon.svg') }}" alt="Delete" class="w-5 h-5 min-w-5 min-h-5 object-contain block"/>
                                    <span class="pointer-events-none absolute top-full right-0 mt-2 hidden group-hover:block whitespace-nowrap rounded-md bg-gray-700/90 px-2.5 py-1 text-xs text-white shadow-md z-50">
                                        Delete College
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection