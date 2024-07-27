document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createFolderForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let folderName = document.getElementById('folderName').value;
        fetch(createFolderUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'  // Add this line
            },
            body: JSON.stringify({
                folderName: folderName
            }),
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                // Optionally refresh the page or update the UI
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showToast(data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'An unexpected error occurred', 'danger');
        });
    });
});

function showToast(message, type) {
    // Remove any existing toasts
    const existingToasts = document.querySelectorAll('.toast');
    existingToasts.forEach(toast => toast.remove());

    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toastElement = document.createElement('div');
    toastElement.className = `toast ${type}`;
    toastElement.style.minWidth = '200px';
    toastElement.style.background = type === 'success' ? '#28a745' : '#dc3545';
    toastElement.style.color = 'white';
    toastElement.style.padding = '15px';
    toastElement.style.marginBottom = '10px';
    toastElement.style.borderRadius = '4px';
    toastElement.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
    toastElement.style.opacity = '0';
    toastElement.style.transition = 'opacity 0.3s ease-in-out';

    // Set message
    toastElement.textContent = message;

    // Add toast to container
    toastContainer.appendChild(toastElement);

    // Show toast
    setTimeout(() => {
        toastElement.style.opacity = '1';
    }, 100);

    // Auto-hide toast after 3 seconds
    setTimeout(() => {
        toastElement.style.opacity = '0';
        setTimeout(() => {
            toastElement.remove();
        }, 300);
    }, 3000);

    // Ensure scrolling is not affected
    setTimeout(() => {
        document.body.style.overflow = '';
        window.scrollTo(0, window.scrollY);
    }, 100);
}

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('dropdown-trigger')) {
        const folderId = event.target.getAttribute('data-folder-id');
        const editFolderForm = document.getElementById('editFolderForm');
        const deleteFolderId = document.getElementById('deleteFolderId');

        if (editFolderForm) {
            const editFolderIdInput = editFolderForm.querySelector('#editFolderId');
            const editFolderNameInput = editFolderForm.querySelector('#editFolderName');
            
            if (editFolderIdInput) editFolderIdInput.value = folderId;
            if (editFolderNameInput) {
                // Update this line to always fetch the latest folder name
                editFolderNameInput.value = document.querySelector(`#dropdown-${folderId}`).closest('.card').querySelector('h5').textContent.trim();
            }
        }
        
        const dropdown = document.getElementById(`dropdown-${folderId}`);
        if (dropdown) {
            dropdown.style.display = 'block';

            // Remove existing event listeners
            const oldEditLink = dropdown.querySelector('a[onclick^="showEditModal"]');
            const newEditLink = oldEditLink?.cloneNode(true);
            if (oldEditLink && newEditLink) {
                oldEditLink.parentNode.replaceChild(newEditLink, oldEditLink);
            }

            // Add new event listener for edit
            newEditLink?.addEventListener('click', function(e) {
                e.preventDefault();
                const editFolderModal = new bootstrap.Modal(document.getElementById('editFolderModal'));
                
                // Set the current folder name right before showing the modal
                const currentFolderName = document.querySelector(`#dropdown-${folderId}`).closest('.card').querySelector('h5').textContent.trim();
                document.getElementById('editFolderName').value = currentFolderName;
                
                editFolderModal.show();
            });

            newDeleteLink?.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteFolderModal = new bootstrap.Modal(document.getElementById('deleteFolderModal'));
                deleteFolderModal.show();
            });
        }

        if (deleteFolderId) deleteFolderId.value = folderId;
    }
});

function showEditModal(folderId, folderName) {
    // Set the values in the form fields
    document.getElementById('editFolderId').value = folderId;
    document.getElementById('editFolderName').value = folderName;
    
    // Show the edit modal
    const editFolderModal = new bootstrap.Modal(document.getElementById('editFolderModal'));
    editFolderModal.show();
}


document.getElementById('editFolderForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const folderId = document.getElementById('editFolderId').value;
    const newName = document.getElementById('editFolderName').value;

    fetch(`/faculty-records/edit/${folderId}`, {
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
            const folderCard = document.querySelector(`#dropdown-${folderId}`).closest('.card');
            const folderNameElement = folderCard.querySelector('h5');
            folderNameElement.textContent = newName;
            
            const editFolderModal = document.getElementById('editFolderModal');
            const modal = bootstrap.Modal.getInstance(editFolderModal);
            modal.hide();
            
            const resetScrollState = () => {
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                window.scrollTo(0, window.scrollY);
            };

            setTimeout(() => {
                resetScrollState();
                showToast('Folder renamed successfully!', 'success');
            }, 300);

            setTimeout(() => {
                if (document.body.classList.contains('modal-open')) {
                    resetScrollState();
                }
            }, 1000);
        } else {
            showToast('Error renaming folder', 'danger');
        }
    })
    .catch(() => {
        showToast('Error renaming folder', 'danger');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });
    });
});

document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown-container')) {
        const dropdowns = document.querySelectorAll('.custom-dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }
});


//delete folder
function deleteFolder(folderId) {
    fetch(`/faculty-records/delete/${folderId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const folderElement = document.querySelector(`#dropdown-${folderId}`);
            folderElement.classList.add('trashed'); 
            folderElement.closest('.col-sm-4').remove(); 
            showToast('Folder moved to trash', 'success');
        } else {
            showToast('Error moving folder to trash', 'danger');
        }
    })
    .catch(() => {
        showToast('Error moving folder to trash', 'danger');
    });
}


document.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-folder')) {
        event.preventDefault();
        const folderId = event.target.getAttribute('data-folder-id');
        deleteFolder(folderId); 
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
        container.className = 'position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
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