<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Profile</title>
    <!-- [Meta] -->
    @include('faculty-partials.faculty-header')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>

    @include('faculty-partials.faculty-sidebar')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Main Content ] start -->
            <div class="row gutters">

                <!-- Personal Details Section -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <!-- Personal Details -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2 text-primary">Profile</h6>
                                </div>
                                <form action="{{ route('faculty.profile-update') }}" method="POST">
                                    @csrf
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif

                                    <div class="row gutters">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="firstName">First Name</label>
                                                <input type="text" class="form-control" id="firstName"
                                                    value="{{ $facultyDetails['first_name'] ?? '' }}" name="first_name">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="middle_name">Middle Name</label>
                                                <input type="text" class="form-control" id="middle_name"
                                                    value="{{ $facultyDetails['middle_name'] ?? '' }}" name="middle_name">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name"
                                                    value="{{ $facultyDetails['last_name'] ?? '' }}" name="last_name">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email"
                                                    placeholder="Enter email"
                                                    value="{{ $facultyDetails['email'] ?? '' }}" name="email">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="birthdate">Birthday</label>
                                                <input type="date" class="form-control" id="birthdate"
                                                    value="{{ $facultyDetails['birthday']->format('Y-m-d') }}" name="birthday">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="sex">Gender</label>
                                                <select class="form-control" id="sex" name="sex">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"
                                                        {{ $facultyDetails['sex'] == 'Male' ? 'selected' : '' }}>Male
                                                    </option>
                                                    <option value="Female"
                                                        {{ $facultyDetails['sex'] == 'Female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <input type="text" class="form-control" id="department"
                                                    value="{{ $facultyDetails['department'] ?? '' }}" name="department">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="id_number">ID Number</label>
                                                <input type="text" class="form-control" id="id_number"
                                                    value="{{ $facultyDetails['id_number'] ?? '' }}" name="id_number">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="employee_type">Employee Type</label>
                                                <select class="form-control" id="employee_type" name="employee_type">
                                                    <option value="">Select employee type</option>
                                                    <option value="Part Time"
                                                        {{ $facultyDetails['employee_type'] == 'Part Time' ? 'selected' : '' }}>
                                                        Part Time
                                                    </option>
                                                    <option value="Regular"
                                                        {{ $facultyDetails['employee_type'] == 'Regular' ? 'selected' : '' }}>
                                                        Regular
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="phone_number">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    value="{{ $facultyDetails['phone_number'] ?? '' }}" name="phone_number">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="row justify-content-center gutters">
                                        <div class="col-md-6 col-lg-4">
                                            <div class="text-center">
                                                <button type="submit" id="submit-button" name="submit-button" class="btn btn-primary w-100 mt-3">Update Profile</button>
                                            </div>
                                        </div>
                                    </div>
                                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
        @include('faculty-partials.faculty-footer')

    </div>
</body>
<!-- [Body] end -->

</html>
