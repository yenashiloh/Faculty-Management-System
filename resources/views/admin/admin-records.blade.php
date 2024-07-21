<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Record</title>
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
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between">
                            <ul class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">YEAR SEMESTRAL ENDS</li>
                            </ul>
                            <div class="col-md-4 text-end mt-0">
                                <div class="dropdown-container">
                                    <i class="fas fa-ellipsis-h dropdown-trigger" onclick="toggleDropdown()"></i>
                                    <div class="dropdown-menu" id="dropdownMenu">
                                        <a href="#" class="dropdown-item">Upload</a>
                                        <a href="#" class="dropdown-item">Pull Records</a>
                                        <a href="#" class="dropdown-item">Push Records</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ semestral] start -->
                <div class="col-sm-4">
                    <a href="{{ route('admin.records.records_1') }}" class="card-link">
                        <div class="card card-semester">
                            <div class="card-header">
                                <h5 class="text-center">1st Semester 21-22</h5>
                            </div>
                            <div class="card-body d-flex justify-content-center align-items-center"
                                style="height: 200px;">
                                <i class="fas fa-folder-open" style="color: #E4E501; font-size: 100px;"></i>
                            </div>
                    </a>
                </div>
                <!-- [ semestral] end -->
            </div>

            <div class="col-sm-4">
                <a href="records_2.html" class="card-link">
                    <div class="card card-semester">
                        <div class="card-header">
                            <h5 class="text-center">2nd Semester 21-22</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                            <i class="fas fa-folder-open" style="color: #E4E501; font-size: 100px;"></i>
                        </div>
                </a>
            </div>
            <!-- [ semestral] end -->
        </div>

        <div class="col-sm-4">
            <a href="#" class="card-link">
                <div class="card card-semester">
                    <div class="card-header">
                        <h5 class="text-center">1st Semester 22-23</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                        <i class="fas fa-folder-open" style="color: #E4E501; font-size: 100px;"></i>
                    </div>
            </a>
        </div>
        <!-- [ semestral] end -->
    </div>
    <!-- [ Main Content ] end -->
    </div>
    </div>
    <!-- [ Main Content ] end -->
    @include('admin-partials.admin-footer')

</body>
<!-- [Body] end -->

</html>
