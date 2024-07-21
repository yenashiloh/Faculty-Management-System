<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>History</title>
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
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">HISTORY</li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-end">
                            <i class="fas fa-sort-amount-up"></i> Sort By: Date (Ascending)
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Permission Requests (for downloading files)</h4>
                            </div>
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Actions</th>
                                        <th>Timestamp</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>July 19, 2024, 09:30 AM</td>
                                        <td>Uploaded a file</td>
                                        <td>July 19, 2024, 09:30 AM</td>
                                        <td>Edit File</td>
                                    </tr>
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
