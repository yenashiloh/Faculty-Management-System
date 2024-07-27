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
<style>
   .ck-editor__editable_inline {
      min-height: 250px; /* Adjust this value to set the desired height */
    }
</style>
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
                                <li class="breadcrumb-item fw-bolder fs-4 mb-0">MAINTENANCE MODULE</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="col-xl-12 mt-4">
      
                <div class="card">
                  <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
      
                      <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#announcement">Announcement</button>
                      </li>
      
                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                      </li>
      
                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                      </li>
      
                    </ul>
                    <div class="tab-content pt-2">
      
                      <div class="tab-pane fade show active profile-overview" id="announcement">
                        <br>
      
                        <div class="form-group">
                          <label for="exampleInputEmail1">Subject</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter subject">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Message</label>
                          <textarea id="announcement-editor"></textarea>
                        </div>
 

                      </div>
      
                      <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
      
                        <!-- Profile Edit Form -->
                        <form method="POST" action="">
                      
                          <div class="row mb-3" id="profileSuccessAlert">
                          
                        </div>
      
                          <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="firstName" type="text" class="form-control" id="firstName" value="" required>
                            </div>
                          </div>
      
                          <div class="row mb-3">
                            <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="lastName" type="text" class="form-control" id="lastName" value="" required>
                            </div>
                          </div>
      
                          <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="email" type="text" class="form-control" id="email" value="" required>
                            </div>
                          </div>
      
                          <div class="row mb-3">
                            <label for="contactNumber" class="col-md-4 col-lg-3 col-form-label">Contact Number</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="contactNumber" type="text" class="form-control" id="contactNumber" value="" required>
                            </div>
                          </div>
      
                          <div class="text-center">
                            <button type="submit" class="btn custom-btn">Save Changes</button>
                          </div>
                        </form><!-- End Profile Edit Form -->
      
                      </div>
      
        
                      <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Change Password Form -->
                        <form method="POST" action="">
                       
                          <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0 auto;  margin-bottom: 10px; width: 500px;">
                            
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                      <div class="row mb-3" id="passwordSuccessAlert">
                      
                    </div>
      
                         <div class="row mb-3" >
                          <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                          </div>
                      </div>
              
                      <div class="row mb-3">
                          <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="newPassword" type="password" class="form-control" id="newPassword" required>
                          </div>
                      </div>
              
                      <div class="row mb-3">
                          <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="renewPassword" type="password" class="form-control" id="renewPassword" required>
                          </div>
                      </div>
              
                          <div class="text-center">
                            <button type="submit" class="btn custom-btn ">Change Password</button>
                          </div>
                        </form><!-- End Change Password Form -->
                      </div>
                    </div><!-- End Bordered Tabs -->


            <!-- [ Main Content ] start -->
          
        </div>
        <!-- [ Main Content ] end -->
        @include('admin-partials.admin-footer')

</body>
<!-- [Body] end -->

</html>
<script>
  
  ClassicEditor
    .create(document.querySelector('#announcement-editor'), {
      toolbar: [
        'heading', '|', 
        'bold', 'italic', 'underline', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
        'insertTable', '|',
        'uploadImage', 'mediaEmbed', '|',
        'undo', 'redo'
      ],
      image: {
        toolbar: [
          'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
        ]
      },
    })
    .catch(error => {
      console.error(error);
    });
</script>
