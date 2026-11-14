@extends('admin.layout')

@section('directory')
    Workspace > Manage Buildings > Edit {{ $building->code }}
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.buildings.show', $building->id) }}" class="text-gray-400">
            &larr; <span class="text-sm hover:underline">Back to Building</span>
        </a>
        <h3 class="mt-2 text-2xl font-bold text-gray-800">Edit Building</h3>
        <p class="mt-1 text-sm text-gray-500">Update the building details and operating hours.</p>
    </div>

    <div class="rounded-md bg-white pb-5">
        <div class="flex items-center gap-3 rounded-lg px-7 pt-5">
            <div class="flex h-14 w-14 items-center justify-center rounded-4xl bg-emerald-100">
                <img src="{{ asset('images/college-icon.svg') }}" alt="">
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Building Information</h3>
                <p class="text-sm text-gray-500">Edit the basic details for this building.</p>
            </div>
        </div>

        <div class="mt-4 mb-2 bg-white px-8">
            <hr class="my-3 border-gray-300">

            <form action="{{ route('admin.buildings.update', $building->id) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="flex flex-col gap-2">
                        @foreach (['college_id', 'name', 'code', 'start_time', 'end_time'] as $field)
                            @error($field)
                                <div class="flex items-center gap-2 rounded-md bg-red-100/80 px-4 py-2 text-sm font-semibold text-red-500">
                                    <img class="h-4 w-4" src="{{ asset('images/info-icon.svg') }}" alt="">
                                    {{ $message }}
                                </div>
                            @enderror
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-col gap-2">
                    <label for="college_id" class="text-md font-semibold text-gray-700">
                        Assigned College <span class="text-red-700">&ast;</span>
                    </label>
                    <select id="college_id" name="college_id" required
                        class="w-full cursor-pointer border border-gray-700 bg-white px-4 py-2 text-sm transition-all focus:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-100">
                        @foreach ($colleges as $college)
                            <option value="{{ $college->id }}" {{ old('college_id', $building->college_id) == $college->id ? 'selected' : '' }}>
                                {{ $college->code }} - {{ $college->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="name" class="text-md font-semibold text-gray-700">
                        Building Name <span class="text-red-700">&ast;</span>
                    </label>
                    <input id="name" class="w-full border border-gray-700 px-4 py-2 text-sm transition-all focus:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-100"
                        type="text" name="name" value="{{ old('name', $building->name) }}" maxlength="300" required>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="code" class="text-md font-semibold text-gray-700">
                        Building Code <span class="text-red-700">&ast;</span>
                    </label>
                    <input id="code" class="w-full border border-gray-700 px-4 py-2 text-sm transition-all focus:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-100"
                        type="text" name="code" value="{{ old('code', $building->code) }}" maxlength="50" required>
                </div>

                <div class="flex flex-col justify-center gap-2">
                    <h4 class="text-md font-semibold text-gray-800">Operating Hours</h4>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <div class="flex flex-1 flex-col gap-2">
                            <label for="start_time" class="text-md text-gray-700">
                                Start Time <span class="text-red-700">&ast;</span>
                            </label>
                            <input id="start_time" class="w-full border border-gray-700 px-4 py-2 text-sm transition-all focus:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-100"
                                type="time" name="start_time" value="{{ old('start_time', substr($building->start_time ?? '07:00', 0, 5)) }}" required>
                        </div>
                        <div class="flex flex-1 flex-col gap-2">
                            <label for="end_time" class="text-md text-gray-700">
                                Closing Time <span class="text-red-700">&ast;</span>
                            </label>
                            <input id="end_time" class="w-full border border-gray-700 px-4 py-2 text-sm transition-all focus:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-100"
                                type="time" name="end_time" value="{{ old('end_time', substr($building->end_time ?? '21:00', 0, 5)) }}" required>
                        </div>
                    </div>
                </div>

                <hr class="my-2 border-gray-300">

                <div class="flex items-center justify-end gap-2.5">
                    <a href="{{ route('admin.buildings.show', $building->id) }}"
                        class="flex items-center justify-center rounded-md border border-gray-600 px-6 py-2 hover:bg-gray-100 active:bg-gray-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex items-center justify-center rounded-md border border-blue-500 bg-blue-500 px-4 py-2 text-white transition-all hover:bg-blue-400 active:bg-blue-300">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection