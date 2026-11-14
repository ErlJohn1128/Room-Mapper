<div id="roomAvailabilityModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-900/50 px-4" role="dialog" aria-modal="true" aria-labelledby="roomAvailabilityModalTitle">
    <div class="w-full max-w-md rounded-sm bg-white p-6 shadow-xl">
        <h2 id="roomAvailabilityModalTitle" class="text-lg font-semibold text-gray-900">Disable this room?</h2>
        <p id="roomAvailabilityModalMessage" class="mt-2 text-sm text-gray-600">This room will be excluded from availability.</p>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeRoomAvailabilityModal()" class="rounded-sm border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button id="roomAvailabilityModalConfirm" type="button" onclick="confirmRoomAvailability()" class="rounded-sm bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700">
                Disable
            </button>
        </div>
    </div>
</div>
