document.getElementById('createFolderForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let folderName = document.getElementById('folderName').value;
    fetch(createFolderUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                folderName: folderName
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = currentUrl;
            } else {
                showToast('Error creating folder', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error creating folder', 'danger');
        });
});

document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 3000);
    }
});

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('dropdown-trigger')) {
        const folderId = event.target.getAttribute('data-folder-id');
        const editFolderForm = document.getElementById('editFolderForm');
        const deleteFolderId = document.getElementById('deleteFolderId');

        editFolderForm.querySelector('#editFolderId').value = folderId;
        editFolderForm.querySelector('#editFolderName').value = event.target.closest('.card').querySelector('h5').textContent;
        
        const dropdown = document.getElementById(`dropdown-${folderId}`);
        dropdown.style.display = 'block';

        dropdown.querySelector('a[onclick^="showEditModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            const editFolderModal = new bootstrap.Modal(document.getElementById('editFolderModal'));
            editFolderModal.show();
        });

        dropdown.querySelector('a[onclick^="showDeleteModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            const deleteFolderModal = new bootstrap.Modal(document.getElementById('deleteFolderModal'));
            deleteFolderModal.show();
        });

        deleteFolderId.value = folderId;
    }
});

document.getElementById('editFolderForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const folderId = document.getElementById('editFolderId').value;
    const newName = document.getElementById('editFolderName').value;

    fetch(`/admin-records/edit/${folderId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ name: newName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`#dropdown-${folderId}`).closest('.card').querySelector('h5').textContent = newName;
            showToast('Folder renamed successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('editFolderModal')).hide();
        } else {
            showToast('Error renaming folder', 'danger');
        }
    })
    .catch(() => {
        showToast('Error renaming folder', 'danger');
    });
});

function deleteFolder(folderId) {
    fetch(`/admin-records/delete/${folderId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`#dropdown-${folderId}`).closest('.col-sm-4').remove();
            showToast('Folder deleted successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('deleteFolderModal')).hide();
        } else {
            showToast('Error deleting folder', 'danger');
        }
    })
    .catch(() => {
        showToast('Error deleting folder', 'danger');
    });
}

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-folder')) {
        event.preventDefault();
        const folderId = event.target.getAttribute('data-folder-id');
        document.getElementById('deleteFolderId').value = folderId;
        const deleteFolderModal = new bootstrap.Modal(document.getElementById('deleteFolderModal'));
        deleteFolderModal.show();
    }
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    const folderId = document.getElementById('deleteFolderId').value;
    deleteFolder(folderId);
});

function showToast(message, type) {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(container);
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

    document.getElementById('toast-container').appendChild(toastElement);

    const toast = new bootstrap.Toast(toastElement, { delay: 5000 });
    toast.show();
}