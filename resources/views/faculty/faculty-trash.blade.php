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
                        <div class="col-md-6 text-end">
                            <i class="fas fa-sort-amount-up"></i> Sort By: Last Edited
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
                            <button class="btn btn-primary">Empty Trash</button>
                        </div>
                        <table id="myTable" class="table">
                            <thead>
                                <tr>
                                    <th>Date and Time</th>
                                    <th>File Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>July 19, 2024, 09:30 AM</td>
                                    <td>bsit-3.xsl</td>
                                    <td>
                                        <div class="dropdown-dots">
                                          <button class="dropbtn"><i class="fas fa-ellipsis-h"></i></button>
                                          <div class="dropdown-content">
                                            <a href="#">Restore</a>
                                          </div>
                                        </div>
                                      </td>
                                </tr>
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
