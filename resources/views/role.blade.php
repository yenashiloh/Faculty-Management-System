<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role</title>

    <link rel="icon" href="../assets/images/pup-logo.png" type="image/x-icon"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="../assets/fonts/feather.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="../assets/fonts/material.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style-preset.css">
    <link rel="stylesheet" href="../assets/css/role.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="bg-container d-flex justify-content-center align-items-center vh-100">
        <div class="bg-image">
            <img class="bg-image" src="assets/images/PUP_1.jpeg" alt="">
        </div>
        <div class="overlay"></div>
        <div class="card-role text-center mx-auto">
            <img class="logo-role mb-4" src="../assets/images/pup-logo.png" alt="PUP Logo">
            <h2 class="text-role mb-4">WELCOME TO PUP-T FACULTY ACADEMIC REQUIREMENTS MANAGER</h2>
            <div class="btn-container d-flex justify-content-center">
                <a href="{{route ('faculty-login')}}" class="btn btn-primary mx-2 fs-4">Faculty</a>
                <a href="{{route ('admin-login')}}" class="btn btn-danger mx-2 fs-4">Admin</a>
            </div>
        </div>
    </div>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
