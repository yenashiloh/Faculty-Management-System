<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>

    @include('admin-partials.admin-header')
    <link rel="stylesheet" href="../assets/css/role.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        .otp-field {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .otp-field input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 24px;
        }
    </style>
</head>
<body class="container-fluid bg-body-tertiary d-block">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4" style="min-width: 500px;">
            <div class="card bg-white mb-5 mt-5 border-0" style="box-shadow: 0 12px 15px rgba(0, 0, 0, 0.02);">
                <div class="card-body p-5 text-center">
                    <h4>Verify</h4>
                    <p>Your code was sent to you via email</p>

                    @if ($errors->any())
                        <div class="text-center" id="errorMessage" style="color: red; font-size: 12px;">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verify-otp') }}" id="otpForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ old('email', session('email')) }}">

                        <div class="otp-field mb-4">
                            <input type="number" maxlength="1" pattern="\d" required>
                            <input type="number" maxlength="1" pattern="\d" required disabled>
                            <input type="number" maxlength="1" pattern="\d" required disabled>
                            <input type="number" maxlength="1" pattern="\d" required disabled>
                            <input type="number" maxlength="1" pattern="\d" required disabled>
                            <input type="number" maxlength="1" pattern="\d" required disabled>
                        </div>
                        <input type="hidden" name="otp" id="otpValue">

                        <button type="submit" class="btn btn-primary mb-3" disabled>
                            Verify
                        </button>
                    </form>

                    <p class="resend text-muted mb-0">
                        Didn't receive code? 
                        <form id="resendForm" method="POST" action="{{ route('resend-otp') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="email" value="{{ old('email', session('email')) }}">
                            <a href="#" onclick="document.getElementById('resendForm').submit(); return false;">Request again</a>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    @include('admin-partials.admin-footer')
    <script src="../assets/js/verification-otp.js"></script>

</body>
</html>
