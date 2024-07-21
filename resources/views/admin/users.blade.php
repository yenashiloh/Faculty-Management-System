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
                                    <th>Name</th>
                                    <th>ID Number</th>
                                    <th>Employee Type</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                    <!-- Add more column headers as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Shiloh Eugenio</td>
                                    <td>9999</td>
                                    <td>Regular</td>
                                    <td>CCIS</td>
                                    <td><button type="button" class="btn btn-primary">View</button></td>
                                    <!-- Add more rows and data as needed -->
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
