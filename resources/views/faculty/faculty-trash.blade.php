<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Trash</title>
    <!-- [Meta] -->
    @include('faculty-partials.faculty-header')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>

    @include('faculty-partials.faculty-sidebar')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">BACK UP AND RESTORE</li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-end d-flex justify-content-end align-items-center">
                            <span class="me-3">
                                <i class="fas fa-sort-amount-up"></i> Sort By:
                            </span>
                            <div class="dropdown d-inline">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Last Trashed
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item" href="{{ route('sort-trash', ['sort' => 'latest']) }}">Last Trashed</a></li>
                                    <li><a class="dropdown-item" href="{{ route('sort-trash', ['sort' => 'oldest']) }}">Oldest Trashed</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-primary ms-3">Empty Trash</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- Table and other content here -->
  
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>File Name/Folder</th>
                                        <th>Owner</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($trashedItems as $trash)
                                        <tr>
                                            <td>{{ $trash->updated_at->format('F j, Y g:i A') }}</td>



                                            <td>{{ $trash->file_name ?? 'N/A' }}</td>
                                            <td>{{ $trash->faculty->first_name ?? 'N/A' }} {{ $trash->faculty->last_name ?? 'N/A' }}</td>
                                            <td>
                                                <div class="dropdown-dots">
                                                    <button class="dropbtn"><i class="fas fa-ellipsis-h"></i></button>
                                                    <div class="dropdown-content">
                                                        <a href="{{ route('restore-trash', ['id' => $trash->semestral_id]) }}">Restore</a>
                                                    </div>
                                                    <div class="dropdown-content">
                                                        <a href="{{ route('delete-trash', ['id' => $trash->semestral_id]) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No trashed items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            
                                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
        @include('faculty-partials.faculty-footer')

</body>
<!-- [Body] end -->

</html>
