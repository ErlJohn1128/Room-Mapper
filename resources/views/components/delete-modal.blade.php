<div id="deleteModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-900/50 px-4" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
    <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
        <div class="flex items-center justify-center w-12 h-12 rounded-4xl bg-red-100/60">
            <img class="w-6 h-6" src="{{ asset('images/red-delete-icon.svg') }}"/>
        </div>

        <h2 id="deleteModalTitle" class="mt-2 font-semibold text-gray-900">Are you sure to delete this college?</h2>
        <p id="deleteModalMessage" class="text-sm text-gray-600">
            This action is permanent and cannot be undone. Once deleted, the item will be removed from your account.
        </p>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                No, Cancel
            </button>
            <button id="deleteModalConfirm" type="button" onclick="confirmDelete()" class="rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

