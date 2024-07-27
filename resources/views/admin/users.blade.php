<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Users</title>
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
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">USERS</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>ID Number</th>
                                        <th>Employee Type</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($facultyData as $faculty)
                                        <tr>
                                            <td>{{ $count }}.</td>
                                            <td>{{ $faculty->first_name }} {{ $faculty->last_name }}</td>
                                            <td>{{ $faculty->id_number }}</td>
                                            <td>{{ $faculty->employee_type }}</td>
                                            <td>{{ $faculty->department }}</td>
                                            <td><button type="button" class="btn btn-primary">View</button></td>
                                        </tr>
                                        @php
                                            $count++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
        @include('admin-partials.admin-footer')

</body>
<!-- [Body] end -->

</html>
