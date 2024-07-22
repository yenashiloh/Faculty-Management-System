<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\FacultyAccount;
use App\Models\FacultyPersonalDetails;

class FacultyController extends Controller
{
    //landing page role 
    public function showRolePage()
    {
        return view('role');
    }

    //login
    public function showLoginPage()
    {
        return view('faculty-login');
    }

    //records
    public function showRecordsPage()
    {
        if (!auth()->check()) {
            return redirect()->route('faculty-login');
        }
    
        $facultyDetails = $this->getFacultyDetails();
        return view('faculty.faculty-records', compact('facultyDetails'));
    }

    //trash
    public function showTrashPage()
    {
        return view('faculty.faculty-trash');
    }

    //history
    public function showHistoryPage()
    {
        return view('faculty.history');
    }

    //storage
    public function showStoragePage()
    {
        return view('faculty.faculty-storage');
    }

    //profile 
    public function showProfilePage()
    {
        if (!auth()->check()) {
            return redirect()->route('faculty-login');
        }

        $facultyDetails = $this->getFacultyDetails();
        return view('faculty.faculty-profile', compact('facultyDetails'));
    }

    //update profile
    // public function updateProfile(Request $request)
    // {
      
    //     // Validate the incoming request
    //     $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'middle_name' => 'nullable|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'birthday' => 'required|date',
    //         'sex' => 'required|string',
    //         'department' => 'required|string|max:255',
    //         'id_number' => 'required|string|max:255',
    //         'employee_type' => 'required|string',
    //         'phone_number' => 'required|string|max:15',
    //     ]);
    
    //     try {
    //         // Get the authenticated user
    //         $faculty = Auth::user();
    //         Log::info('Attempting to update profile for user: ' . $faculty->faculty_account_id);
    //         // Update the faculty account details
    //         $faculty->update([
    //             'email' => $request->input('email'),
    //         ]);
    
    //         // Update or create personal details
    //         $personalDetails = $faculty->personalDetails()->firstOrNew(['faculty_account_id' => $faculty->faculty_account_id]);
    //         $personalDetails->update([
    //             'first_name' => $request->input('first_name'),
    //             'middle_name' => $request->input('middle_name'),
    //             'last_name' => $request->input('last_name'),
    //             'birthday' => $request->input('birthday'),
    //             'sex' => $request->input('sex'),
    //             'department' => $request->input('department'),
    //             'id_number' => $request->input('id_number'),
    //             'employee_type' => $request->input('employee_type'),
    //             'phone_number' => $request->input('phone_number'),
    //         ]);
    
    //         // Redirect back with a success message
    //         return redirect()->route('faculty-profile')->with('success', 'Profile updated successfully!');
    //     } catch (\Exception $e) {
    //         // Log the exception message
    //         Log::error('Profile update failed: ' . $e->getMessage());
    
    //         // Redirect back with an error message
    //         return redirect()->route('faculty-profile')->with('error', 'An error occurred while updating your profile. Please try again.');
    //     }
    // }
    
//     public function updateProfile(Request $request)
// {
//     $facultyAccount = Auth::guard('faculty_account')->user();
    
//     if ($facultyAccount) {
//         $validateData = $request->validate([
//             'first_name' => 'required|string|max:255',
//             'middle_name' => 'nullable|string|max:255',
//             'last_name' => 'required|string|max:255',
//             'email' => 'required|email|unique:faculty_account,email,' . $facultyAccount->faculty_account_id,
//             'birthday' => 'required|date',
//             'sex' => 'required|in:Male,Female', 
//             'department' => 'required|string|max:255',
//             'id_number' => 'required|string|max:255',
//             'employee_type' => 'required|in:Part Time,Regular',
//             'phone_number' => 'required|string|max:11',
//         ]);

//         $facultyAccount->update([
//             'email' => $validateData['email'],
//         ]);

//         $facultyAccount->personalDetails()->update([
//             'first_name' => $validateData['first_name'],
//             'middle_name' => $validateData['middle_name'],
//             'last_name' => $validateData['last_name'],
//             'birthday' => $validateData['birthday'],
//             'sex' => $validateData['sex'],
//             'department' => $validateData['department'],
//             'id_number' => $validateData['id_number'],
//             'employee_type' => $validateData['employee_type'],
//             'phone_number' => $validateData['phone_number'],
//         ]);
        
//         $request->session()->flash('success', 'Profile updated successfully!');
//         return redirect()->route('faculty.faculty-profile');
//     } else {
//         $request->session()->flash('error', 'Failed to update profile.');
//         return redirect()->route('faculty.faculty-profile');
//     }
// }

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
    
    //create account
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

    //login faculty
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
            return redirect()->intended(route('faculty.faculty-records')); // Redirect to records page
        }

        return redirect(route('faculty-login'))->with("error", "Incorrect email address or password. Please try again.");
    }

    //verification otp
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

    //resed otp
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

    //logout
    public function facultyLogout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('faculty-login'));
    }

    public function getFacultyDetails()
    {
        if (Auth::check()) {
            $faculty = Auth::user();
            $personalDetails = $faculty->personalDetails;
            $email = $faculty->email;
            return [
                'first_name' => $personalDetails->first_name,
                'middle_name' => $personalDetails->middle_name,
                'last_name' => $personalDetails->last_name,
                'email' => $email,
                'birthday' => $personalDetails->birthday,
                'sex' => $personalDetails->sex,
                'department' => $personalDetails->department,
                'id_number' => $personalDetails->id_number,
                'employee_type' => $personalDetails->employee_type,
                'phone_number' => $personalDetails->phone_number,
            ];
        }
        return null;
    }

   
}
