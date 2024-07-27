<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Announcement</title>
    <!-- [Meta] -->
    @include('admin-partials.admin-header')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>

    @include('admin-partials.admin-sidebar')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header" style="margin-bottom: 25px;">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between">
                            <ul class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">ANNOUNCEMENT</li>
                            </ul>
                            <div class="col-md-4 text-end mt-0">
                                <div class="dropdown-container">
                                    <a href="{{ route('admin.announcement.add-announcement') }}"
                                        class="btn btn-primary"><i class="fas fa-plus fs-6"></i> Create Announcement</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
    
            <div class="container mt-4">
                @foreach ($announcements as $announcement)
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title fs-4">{{ $announcement->subject }}</h5>
                                <div class="d-flex align-items-center">
                                    <!-- Publication Status -->
                                    <span class="me-3">
                                        @if ($announcement->published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Unpublished</span>
                                        @endif
                                    </span>
                                    <!-- Dropdown Menu -->
                                    <div class="dropdown">
                                        <div class="dropdown-container">
                                            <i class="fas fa-ellipsis-h dropdown-trigger"
                                                onclick="toggleDropdown({{ $announcement->id_announcement }})"></i>
                                            <div class="dropdown-menu"
                                                id="dropdownMenu{{ $announcement->id_announcement }}">
                                                <a href="{{ route('admin.announcement.edit-announcement', $announcement->id_announcement) }}"
                                                    class="dropdown-item">Edit</a>
                                                <button type="button" class="dropdown-item delete-btn"
                                                    data-id="{{ $announcement->id_announcement }}">Delete</button>
                                                @if ($announcement->published)
                                                    <a href="{{ route('admin.announcement.unpublish-announcement', $announcement->id_announcement) }}"
                                                        class="dropdown-item">Unpublish</a>
                                                @else
                                                    <a href="{{ route('admin.announcement.publish-announcement', $announcement->id_announcement) }}"
                                                        class="dropdown-item">Publish</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="announcement-timestamp">{{ $announcement->created_at->format('F j, Y') }}</p>
                            <hr>
                            <div>{!! $announcement->message !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Toast Container -->
            <div class="toast-container position-fixed p-3 end-0 bottom-0">
                <div class="toast align-items-center text-white bg-success border-0 mb-2" id="successToast"
                    role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body text-center" data-message="{{ session('success') }}">
                        </div>
                    </div>
                </div>

            </div>

            <!-- [ Main Content ] start -->

        </div>
        <!-- [ Main Content ] end -->
        @include('admin-partials.admin-footer')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
        <script>
            function toggleDropdown(id) {
                const dropdownMenu = document.getElementById('dropdownMenu' + id);
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            }

            window.onclick = function(event) {
                if (!event.target.matches('.dropdown-trigger')) {
                    const dropdowns = document.getElementsByClassName('dropdown-menu');
                    for (let i = 0; i < dropdowns.length; i++) {
                        const dropdown = dropdowns[i];
                        if (dropdown.style.display === 'block') {
                            dropdown.style.display = 'none';
                        }
                    }
                }
            }
        </script>

</body>
<!-- [Body] end -->

</html>
