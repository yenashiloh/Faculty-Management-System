document.addEventListener('DOMContentLoaded', function() {
    // Create Folder
    document.getElementById('createFolderForm')?.addEventListener('submit', function(event) {
        event.preventDefault();
        
        let folderName = document.getElementById('folderName')?.value;
        let semestralId = document.getElementById('currentSemestralId')?.value;

        if (!semestralId) {
            alert('Semestral ID is missing');
            return;
        }

        fetch('/records/create-folder-semestral-ends', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                folderName: folderName,
                semestralId: semestralId
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error creating folder');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error creating folder: ' + error.message);
        });
    });

    let successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.transition = 'opacity 1s';
            successMessage.style.opacity = 0;
            setTimeout(function() {
                successMessage.remove();
            }, 1000);
        }, 5000);
    }

    // Dropdown and Edit/Delete Modal Triggers
    document.addEventListener('click', function(event) {
        const trigger = event.target.closest('.dropdown-trigger');

        if (trigger) {
            const folderId = trigger.getAttribute('data-folder-id');
            const dropdown = document.getElementById(`dropdown-${folderId}`);

            if (dropdown) {
                // Close all dropdowns first
                document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                    dropdown.style.display = 'none';
                });

                event.stopPropagation(); // Prevent the click from immediately closing the dropdown
                dropdown.style.display = 'block';
                
                // Set up edit link
                const editLink = dropdown.querySelector('a[onclick^="showEditModal"]');
                if (editLink) {
                    editLink.onclick = function(e) {
                        e.preventDefault();
                        showEditModal(folderId);
                    };
                }

                // Set up delete link
                const deleteLink = dropdown.querySelector('.delete-folder');
                if (deleteLink) {
                    deleteLink.onclick = function(e) {
                        e.preventDefault();
                        showDeleteModal(folderId);
                    };
                }
            }
        } else {
            // Close dropdown when clicking outside
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        }
    });

    // Functions to show modals
    function showEditModal(folderId) {
        const editFolderModal = new bootstrap.Modal(document.getElementById('editFolderModal'));
        const editFolderForm = document.getElementById('editFolderForm');
        const editFolderIdInput = editFolderForm.querySelector('#editFolderId');
        const editFolderNameInput = editFolderForm.querySelector('#editFolderName');
        
        editFolderIdInput.value = folderId;
        const folderNameElement = document.querySelector(`#dropdown-${folderId}`).closest('.card').querySelector('h5');
        editFolderNameInput.value = folderNameElement ? folderNameElement.textContent : '';
        
        editFolderModal.show();
    }

    function showDeleteModal(folderId) {
        const deleteFolderModal = new bootstrap.Modal(document.getElementById('deleteFolderModal'));
        const deleteFolderIdInput = document.getElementById('deleteFolderId');
        deleteFolderIdInput.value = folderId;
        deleteFolderModal.show();
    }

    // Edit Folder
    document.getElementById('editFolderForm')?.addEventListener('submit', function(event) {
        event.preventDefault();
        const folderId = document.getElementById('editFolderId')?.value;
        const newName = document.getElementById('editFolderName')?.value;

        fetch(`/records/folder-semestral-ends/edit/${folderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name: newName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const folderElement = document.querySelector(`#dropdown-${folderId}`)?.closest('.card')?.querySelector('h5');
                if (folderElement) folderElement.textContent = newName;
                showToast('Folder renamed successfully!', 'success');
                
                const editFolderModal = document.getElementById('editFolderModal');
                const modal = bootstrap.Modal.getInstance(editFolderModal);
                if (modal) modal.hide();
            } else {
                showToast('Error renaming folder', 'danger');
            }
        })
        .catch(() => {
            showToast('Error renaming folder', 'danger');
        });
    });

    // Delete Folder
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
        const folderId = document.getElementById('deleteFolderId')?.value;
        if (folderId) deleteFolder(folderId);
    });

    function deleteFolder(folderId) {
        fetch(`/records/folder-semestral-ends/delete/${folderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#dropdown-${folderId}`)?.closest('.col-sm-4')?.remove();
                showToast('Folder deleted successfully!', 'success');
                const deleteFolderModal = document.getElementById('deleteFolderModal');
                const modal = bootstrap.Modal.getInstance(deleteFolderModal);
                if (modal) modal.hide();
            } else {
                showToast('Error deleting folder', 'danger');
            }
        })
        .catch(() => {
            showToast('Error deleting folder', 'danger');
        });
    }

    // Toast Function
    function showToast(message, type) {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        const toastElement = document.createElement('div');
        toastElement.className = `toast align-items-center text-white bg-${type} border-0`;
        toastElement.setAttribute('role', 'alert');
        toastElement.setAttribute('aria-live', 'assertive');
        toastElement.setAttribute('aria-atomic', 'true');

        toastElement.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(toastElement);

        const toast = new bootstrap.Toast(toastElement, { delay: 5000 });
        toast.show();
    }
});
