<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    @include('admin-partials.admin-header')
    <link rel="stylesheet" href="../assets/css/role.css">
    <link rel="stylesheet" href="../assets/css/verified-check.css">
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
       
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <svg xmlns="http://www.w3.org/2000/svg" class="svg-success" viewBox="0 0 24 24">
                <g stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                    <circle class="success-circle-outline" cx="12" cy="12" r="11.5" />
                    <circle class="success-circle-fill" cx="12" cy="12" r="11.5" />
                    <polyline class="success-tick" points="17,8.5 9.5,15.5 7,13" />
                </g>
            </svg>
            <h3 class="text-center" style="margin-top: 25px; font-size: 30px;">Your email address is now verified!</h3>
            <p class="text-center" style="margin-top: 15px; font-size: 18px;">Click the Login button to continue</p>
            <div class="d-flex justify-content-center">
                <a href="{{ route('faculty-login') }}" class="btn btn-primary">Login</a>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap 5 JavaScript Bundle -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    @include('admin-partials.admin-footer')
</body>

</html>
