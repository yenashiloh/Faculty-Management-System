<!DOCTYPE html>
<html lang="en">

<head>
    <title>Record</title>
    @include('admin-partials.admin-header')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/records.css">
</head>

<body>
    @include('admin-partials.admin-sidebar')

    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header" style="margin-bottom: 25px;">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between">
                            <ul class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">YEAR SEMESTRAL ENDS</li>
                            </ul>
                            <div class="col-md-4 text-end mt-0">
                                <div class="dropdown-container">
                                    <i class="fas fa-ellipsis-v dropdown-trigger" onclick="toggleDropdown()"></i>
                                    <div class="dropdown-menu" id="dropdownMenu">
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#createFolderModal">Create New Folder</a>
                                        <a href="#" class="dropdown-item">Pull Records</a>
                                        <a href="#" class="dropdown-item">Push Records</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Folder Modal -->
            <div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="createFolderForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="folderName" class="form-label">Folder Name</label>
                                    <input type="text" class="form-control" id="folderName" name="folderName"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Folder Modal -->
            <div class="modal fade" id="editFolderModal" tabindex="-1" aria-labelledby="editFolderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editFolderModalLabel">Edit Folder</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editFolderForm">
                                @csrf
                                <input type="hidden" id="editFolderId" name="folderId">
                                <div class="mb-3">
                                    <label for="editFolderName" class="form-label">Folder Name</label>
                                    <input type="text" class="form-control" id="editFolderName" name="folderName"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Folder Modal -->
            <div class="modal fade" id="deleteFolderModal" tabindex="-1" aria-labelledby="deleteFolderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteFolderModalLabel">Delete Folder</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this folder?</p>
                            <input type="hidden" id="deleteFolderId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (Session::has('success'))
                <div id="successMessage" class="alert alert-success text-center" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div id="toast-container" class="position-fixed bottom-0 end-0 p-3"></div>
            <div class="row existing-folders">
                <!-- Existing folder cards here -->
            </div>

            <div class="row new-folders" id="folderList">
                @foreach ($folders as $folder)
                    <div class="col-sm-4 mb-4">
                        <div class="card card-semester">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ $folder->file_name }}</h5>
                                <div class="dropdown-container">
                                    <i class="fas fa-ellipsis-h dropdown-trigger records-folder"
                                        data-folder-id="{{ $folder->semestral_id }}"></i>
                                    <div class="custom-dropdown" id="dropdown-{{ $folder->semestral_id }}">
                                        <a href="#"
                                            onclick="showEditModal({{ $folder->semestral_id }}, '{{ $folder->file_name }}')">Edit</a>
                                            <a href="#" class="delete-folder" data-folder-id="{{ $folder->semestral_id }}">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('records/folder-semestral-ends/' . $folder->semestral_id) }}" class="card-link">
                                <div class="card-body d-flex justify-content-center align-items-center"
                                    style="height: 200px;">
                                    <i class="fas fa-folder-open folder-records"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
        @include('admin-partials.admin-footer')
        <script src="../assets/js/records.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
        <script>
               var createFolderUrl = "{{ route('create-semestral-folder') }}";
                var currentUrl = "{{ url()->current() }}";
                var csrfToken = "{{ csrf_token() }}";
                
        </script>
        
    </body>

    </html>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
