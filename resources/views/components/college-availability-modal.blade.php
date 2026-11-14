<div id="collegeAvailabilityModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-900/50 px-4" role="dialog" aria-modal="true" aria-labelledby="collegeAvailabilityModalTitle">
    <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
        <h2 id="collegeAvailabilityModalTitle" class="text-lg font-semibold text-gray-900">
            {{ $college->is_active ? 'Disable college availability?' : 'Enable college availability?' }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            @if ($college->is_active)
                Rooms in {{ $college->code }} will no longer be included in availability. Buildings and room records will remain and you can enable availability again later.
            @else
                Rooms in {{ $college->code }} will be included in availability again.
            @endif
        </p>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeCollegeAvailabilityModal()" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" onclick="confirmCollegeAvailability()" class="rounded-lg px-4 py-2 text-sm font-medium text-white {{ $college->is_active ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                {{ $college->is_active ? 'Disable availability' : 'Enable availability' }}
            </button>
        </div>
    </div>
</div>
