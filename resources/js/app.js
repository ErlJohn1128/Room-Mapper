let deleteForm = null;
let disableBuildingForm = null;
let collegeAvailabilityForm = null;
let roomAvailabilityForm = null;

window.openDeleteModal = function(form) {
    deleteForm = form;

    const modal = document.getElementById('deleteModal');
    const title = document.getElementById('deleteModalTitle');
    const message = document.getElementById('deleteModalMessage');
    const confirmButton = document.getElementById('deleteModalConfirm');

    title.textContent = form.dataset.deleteTitle || 'Are you sure to delete this college?';
    message.textContent = form.dataset.deleteMessage || 'This action is permanent and cannot be undone. Once deleted, the item will be removed from your account.';
    confirmButton.textContent = form.dataset.deleteConfirm || 'Yes, Delete';

    modal.classList.remove('hidden');
    modal.classList.add('flex');
};

window.openDisableBuildingModal = function(form) {
    disableBuildingForm = form;

    const modal = document.getElementById('disableBuildingModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    const title = document.getElementById('disableBuildingModalTitle');
    const message = document.getElementById('disableBuildingModalMessage');
    const confirmButton = document.getElementById('disableBuildingModalConfirm');
    const willEnable = form.dataset.action === 'enable';

    title.textContent = willEnable ? 'Enable building availability?' : 'Disable building availability?';
    message.textContent = willEnable
        ? `Rooms in ${form.dataset.buildingCode} will be included in availability again.`
        : `Rooms in ${form.dataset.buildingCode} will be excluded from availability. Their records will remain.`;
    confirmButton.textContent = willEnable ? 'Enable availability' : 'Disable availability';
    confirmButton.classList.remove('bg-rose-600', 'hover:bg-rose-700', 'bg-emerald-600', 'hover:bg-emerald-700');
    confirmButton.classList.add(willEnable ? 'bg-emerald-600' : 'bg-rose-600', willEnable ? 'hover:bg-emerald-700' : 'hover:bg-rose-700');
};

window.openCollegeAvailabilityModal = function(form) {
    collegeAvailabilityForm = form;

    const modal = document.getElementById('collegeAvailabilityModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
};

window.openRoomAvailabilityModal = function(form) {
    roomAvailabilityForm = form;

    const modal = document.getElementById('roomAvailabilityModal');
    const title = document.getElementById('roomAvailabilityModalTitle');
    const message = document.getElementById('roomAvailabilityModalMessage');
    const confirmButton = document.getElementById('roomAvailabilityModalConfirm');
    const willEnable = form.dataset.action === 'enable';

    title.textContent = willEnable ? 'Enable this room?' : 'Disable this room?';
    message.textContent = willEnable
        ? 'This room will be included in availability again.'
        : 'This room will be excluded from availability.';
    confirmButton.textContent = willEnable ? 'Enable' : 'Disable';
    confirmButton.classList.remove('bg-rose-600', 'hover:bg-rose-700', 'bg-emerald-600', 'hover:bg-emerald-700');
    confirmButton.classList.add(willEnable ? 'bg-emerald-600' : 'bg-rose-600', willEnable ? 'hover:bg-emerald-700' : 'hover:bg-rose-700');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
};

window.closeDeleteModal = function() {
    const modal = document.getElementById('deleteModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    deleteForm = null;
};

window.closeDisableBuildingModal = function() {
    const modal = document.getElementById('disableBuildingModal');
    
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    disableBuildingForm = null;
};

window.closeRoomAvailabilityModal = function() {
    const modal = document.getElementById('roomAvailabilityModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
    roomAvailabilityForm = null;
};

window.closeCollegeAvailabilityModal = function() {
    const modal = document.getElementById('collegeAvailabilityModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
    collegeAvailabilityForm = null;
};

window.confirmDelete = function() {
    if (deleteForm) {
        deleteForm.submit();
    }
};

window.confirmDisableBuilding = function() {
    if (disableBuildingForm) {
        disableBuildingForm.submit();
    }
};

window.confirmRoomAvailability = function() {
    if (roomAvailabilityForm) {
        roomAvailabilityForm.submit();
    }
};

window.confirmCollegeAvailability = function() {
    if (collegeAvailabilityForm) {
        collegeAvailabilityForm.submit();
    }
};