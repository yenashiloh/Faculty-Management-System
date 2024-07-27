<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Access Control</title>
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
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">ACCESS CONTROL</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-4">Permission Requests (for downloading files)</h4>
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>Request Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Shiloh Eugenio</td>
                                        <td>Approved</td>
                                        <td>July 19, 2024</td>
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
