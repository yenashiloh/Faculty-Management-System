<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
use App\Models\FacultyAccount;
use App\Models\FacultyPersonalDetails;

class FacultyController extends Controller
{
    public function showRolePage()
    {
        return view('role');
    }

    public function showLoginPage()
    {
        return view('faculty-login');
    }

    public function showRecordsPage()
    {
        return view('faculty.faculty-records');
    }

    public function showTrashPage()
    {
        return view('faculty.faculty-trash');
    }

    public function showHistoryPage()
    {
        return view('faculty.history');
    }

    public function showStoragePage()
    {
        return view('faculty.faculty-storage');
    }

    public function showProfilePage()
    {
        return view('faculty.faculty-profile');
    }

    public function showSignUpPage()
    {
        return view('faculty-sign-up');
    }

    public function showVerificationPage()
    {
        return view('verification.verification');
    }

    public function showOtpVerificationForm()
    {
        return view('otp-verification');
    }

    public function showVerifiedCheck()
    {
        return view('verified');
    }
    
    
    public function signUpPost(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:faculty_account,email',
            'birthday' => 'required|date',
            'sex' => 'required|in:Male,Female', 
            'department' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'employee_type' => 'required|in:Part Time,Regular',
            'phone_number' => 'required|string|max:11',
            'password' => 'required|min:8|confirmed', 
        ]);

        $otp = rand(100000, 999999); 

        $facultyData = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(80), 
            'email_verified_at' => null,
            'verify_status' => false,
            'verification_code' => $otp,
        ];

        $faculty = FacultyAccount::create($facultyData);

        $personalDetailsData = $request->only([
            'first_name',
            'middle_name',
            'last_name',
            'birthday',
            'sex',
            'department',
            'id_number',
            'employee_type',
            'phone_number',
        ]);

        $personalDetailsData['faculty_account_id'] = $faculty->faculty_account_id;
        FacultyPersonalDetails::create($personalDetailsData);

        Mail::send('emails.otp', ['otp' => $otp], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Verification OTP');
            $message->from('facultymanagement@gmail.com', 'FARM System'); 
        });

        Log::info('Registration successful for:', $personalDetailsData);

        return redirect()->route('otp-verification')->with('email', $request->email);

    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $faculty = Auth::user();    

            if ($faculty instanceof FacultyAccount) {
                Log::debug('User is an faculty');

                if (!$faculty->verify_status) {
                    Auth::logout();
                    return redirect(route('faculty-login'))->with("error", "Your email is not verified. Please verify your email before logging in.");
                }

                if ($faculty->verification_code) {
                    Auth::logout();
                    return redirect(route('faculty-login'))->with("error", "Your account is not verified. Please verify your email before logging in.");
                }
            }

            Log::debug('Login successful');
            return redirect()->intended(route('faculty.faculty-records'));
        }

        return redirect(route('faculty-login'))->with("error", "Incorrect email address or password. Please try again.");
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:faculty_account,email',
            'otp' => 'required|digits:6',
        ]);

        $faculty = FacultyAccount::where('email', $request->email)
                                ->where('verification_code', $request->otp)
                                ->first();

        if (!$faculty) {
            return redirect()->back()
                            ->withInput()
                            ->withErrors(['otp' => 'The provided OTP is invalid.']);
        }

        $faculty->email_verified_at = now();
        $faculty->verify_status = true;
        $faculty->verification_code = null;
        $faculty->save();

        return redirect()->route('verified');
    }


    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:faculty_account,email',
        ]);

        $faculty = FacultyAccount::where('email', $request->email)->first();

        $newOtp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $faculty->verification_code = $newOtp;
        $faculty->save();

        Mail::send('emails.otp', ['otp' => $newOtp], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Verification OTP');
            $message->from('facultymanagement@gmail.com', 'FARM System');
        });

        return redirect()->back()->with('message', 'A new OTP has been sent to your email.')
                                ->withInput(['email' => $request->email]);
    }
}
