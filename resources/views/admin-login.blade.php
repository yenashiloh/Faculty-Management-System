<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    @include('admin-partials.admin-header')
    <link rel="stylesheet" href="../assets/css/role.css">
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
</head>

<body>
    <div class="bg-container d-flex justify-content-center align-items-center vh-100">
        <div class="bg-image">
            <img class="bg-image" src="assets/images/PUP_1.jpeg" alt="">
        </div>
        <div class="overlay"></div>
        <div class="card-login text-center mx-auto p-4">
            <img class="logo-login mb-4 mt-4" src="../assets/images/pup-logo.png" alt="PUP Logo">
            <h2 class="text-role mb-4">PUP-T FARM SYSTEM</h2>
            <h3 class="text-role mb-3">Login as Admin</h3>
            <div class="btn-container">
                <form action="{{ route('admin-login.post') }}" method="POST">
                    @csrf
                    @if (session('error'))
                        <div class="text-center" id="errorMessage" style="color: red; font-size: 12px;">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert text-center" style="color: green; font-size: 12px;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="form-floating d-flex justify-content-center mb-3">
                        <input type="email" name="email" class="form-control button-width mt-3" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating d-flex justify-content-center mb-3">
                        <input type="password" name="password" class="form-control button-width" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button type="submit" value="login" class="btn btn-primary mb-3">Login</button>
                </form>
        </div>
    </div>

    <!-- Include Bootstrap 5 JavaScript Bundle -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    @include('admin-partials.admin-footer')

</body>

</html>
