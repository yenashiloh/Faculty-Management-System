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
                <div class="row align-items-center mb-3">
                    <div class="col-md-8">
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item mb-0"><a href="{{route('admin.admin-records')}}" class="fw-bold">Records</a></li>
                            <li class="breadcrumb-item mb-0"><a href="{{route('admin.records.records_1')}}">1st Semester 21-22</a></li>
                        </ul>
                    </div>
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
                <!-- [ dropdowns ] start -->
                <div class="row mb-3">
                    <div class="col-md-2 mt-2">
                        <div class="dropdown">
                            <select class="form-select">
                                <option selected>Types</option>
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-2">
                        <div class="dropdown">
                            <select class="form-select">
                                <option selected>People</option>
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-2">
                        <div class="dropdown">
                            <select class="form-select">
                                <option selected>Modified</option>
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- [ dropdowns ] end -->
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-4">
                <a href="records_1.html" class="card-link">
                    <div class="card card-semester">
                        <div class="card-header">
                            <h5 class="text-center">Classroom Management</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                            <i class="fas fa-folder-open" style="color: #E4E501; font-size: 100px;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <!-- [ sample-page ] end -->

            <div class="col-sm-4">
                <a href="#" class="card-link">
                    <div class="card card-semester">
                        <div class="card-header">
                            <h5 class="text-center">Syllabus Preparation</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                            <i class="fas fa-folder-open" style="color: #E4E501; font-size: 100px;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <!-- [ sample-page ] end -->

            <div class="col-sm-4">
                <a href="{{ route('admin.test-administration.test-administration') }}" class="card-link">
                    <div class="card card-semester">
                        <div class="card-header">
                            <h5 class="text-center">Test Administration</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                            <i class="fas fa-folder-open" style="color: #E4E501; font-size: 100px;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

    <!-- [ Main Content ] end -->
    @include('admin-partials.admin-footer')

</body>
<!-- [Body] end -->

</html>
