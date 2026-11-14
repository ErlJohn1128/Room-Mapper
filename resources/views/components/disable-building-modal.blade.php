<div id="disableBuildingModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-900/50 px-4" role="dialog" aria-modal="true" aria-labelledby="disableBuildingModalTitle">
    <div class="w-full max-w-md rounded-sm bg-white p-6 shadow-xl">
        <div class="flex items-center justify-center w-12 h-12 rounded-sm bg-red-100/60">
            <img class="w-6 h-6" src="{{ asset('images/disbale-building-icon.svg') }}" alt=""/>
        </div>

        <h2 id="disableBuildingModalTitle" class="mt-2 font-semibold text-gray-900">
            {{ $building->is_active ? 'Disable building availability?' : 'Enable building availability?' }}
        </h2>
        <p id="disableBuildingModalMessage" class="text-sm text-gray-600">
            {{ $building->is_active ? 'This will exclude rooms in this building from availability. Room records will remain.' : 'This will include rooms in this building in availability again.' }}
        </p>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDisableBuildingModal()" class="rounded-sm border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button id="disableBuildingModalConfirm" type="button" onclick="confirmDisableBuilding()" class="rounded-sm px-4 py-2 text-sm font-medium text-white {{ $building->is_active ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                {{ $building->is_active ? 'Disable availability' : 'Enable availability' }}
            </button>
        </div>
    </div>
</div>