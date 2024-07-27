document.addEventListener('DOMContentLoaded', function() {
    // Show Success Toast
    var successToastElement = document.getElementById('successToast');
    if (successToastElement) {
        var successMessage = successToastElement.querySelector('.toast-body').getAttribute('data-message');
        if (successMessage) {
            var toast = new bootstrap.Toast(successToastElement);
            var toastBody = successToastElement.querySelector('.toast-body');
            toastBody.textContent = successMessage;
            toast.show();
        }
    }

    // Show Error Toast
    var errorToastElement = document.getElementById('errorToast');
    if (errorToastElement) {
        var errorMessage = errorToastElement.querySelector('.toast-body').getAttribute('data-message');
        if (errorMessage) {
            var toast = new bootstrap.Toast(errorToastElement);
            var toastBody = errorToastElement.querySelector('.toast-body');
            toastBody.textContent = errorMessage;
            toast.show();
        }
    }
});

//Delete Sweet Alert
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const url = `/admin/announcement/delete/${id}`;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire(
                                'Deleted!',
                                'Your announcement has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page to reflect the changes
                            });
                        } else {
                            throw new Error('Error deleting the announcement');
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the announcement.',
                            'error'
                        );
                    });
                }
            });
        });
    });
});
