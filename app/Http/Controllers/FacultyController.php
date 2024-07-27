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
use Illuminate\Support\Facades\Validator;
use App\Models\FacultyAccount;
use App\Models\FacultyPersonalDetails;
use App\Models\SemestralEnd;
use App\Models\YearSemestralFolder;


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
        $folders = SemestralEnd::where('trashed', false)->orderBy('created_at', 'desc')->get(); 
        return view('faculty.faculty-records', compact('folders', 'facultyDetails'));
    }

    //edit folder year ends
    public function editRecordFolder(Request $request, $id)
    {
        try {
            \Log::info('Editing folder with ID: ' . $id);
            \Log::info('Request data: ' . json_encode($request->all()));
            
            $folder = SemestralEnd::where('semestral_id', $id)->firstOrFail();
            \Log::info('Found folder: ' . json_encode($folder));
            
            $folder->file_name = $request->name;
            $folder->save();
            
            \Log::info('Folder updated successfully');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error editing folder: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    //delete folder year ends
    public function deleteRecordFolder($id)
    {
        try {
            $folder = SemestralEnd::where('semestral_id', $id)->firstOrFail();
            $folder->trashed = true;
            $folder->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error deleting folder: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
    }


    //faculty year semestral - records
    public function createYearSemestral(Request $request)
    {
        try {
            $request->validate([
                'folderName' => 'required|string|max:255',
            ]);

            $user = Auth::guard('web')->user();

            if (!$user) {
                throw new \Exception('Authentication required');
            }

            $folder = new SemestralEnd();
            $folder->file_name = $request->folderName;

            if ($user instanceof FacultyAccount) {
                $folder->faculty_id = $user->faculty_account_id;
            } elseif ($user instanceof AdminAccount) {
                $folder->admin_id = $user->id; 
            } else {
                throw new \Exception('Invalid user type');
            }

            $folder->save();

            return response()->json([
                'success' => true,
                'message' => 'Folder created successfully!',
                'folder' => $folder
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating folder: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function createFolderSemestralEnds(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'folderName' => 'required|string|max:255',
                'semestralId' => 'required|integer|exists:semestral_ends,semestral_id',
            ]);
    
            if (!auth()->check()) {
                return redirect()->route('faculty-login');
            }
            
            $user = auth()->user();
    
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated user.'
                ], 401);
            }
    
            $currentSemestralEnd = SemestralEnd::findOrFail($validatedData['semestralId']);
    
            $folder = new YearSemestralFolder();
            $folder->folder_name = $validatedData['folderName'];
            $folder->semestral_id = $currentSemestralEnd->semestral_id;
            $folder->admin_id = $user->id;
    
            $folder->save();
    
            Session::flash('success', 'Folder created successfully!');
    
            return response()->json([
                'success' => true,
                'message' => 'Folder created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating folder: ' . $e->getMessage()
            ], 500);
        }
    }
    
    //trash
    public function showTrashPage()
    {
        if (!auth()->check()) {
            return redirect()->route('faculty-login');
        }
    
        $facultyDetails = $this->getFacultyDetails();
    
        $user = auth()->user();
        $facultyAccountId = $user->faculty_account_id;
    
    
        $trashedItems = SemestralEnd::where('trashed', 1)
                            ->where('faculty_id', $facultyAccountId)
                            ->with('faculty') 
                            ->get();

        \Log::info('Trashed items:', $trashedItems->toArray());
    
        return view('faculty.faculty-trash', compact('facultyDetails', 'trashedItems'));
    }
    

    public function restoreTrash($id)
    {
        $item = SemestralEnd::find($id);
        if ($item) {
            $item->trashed = 0; 
            $item->save();
            return redirect()->route('faculty.faculty-trash')->with('success', 'Item restored successfully.');
        }
        return redirect()->route('faculty.faculty-trash')->with('error', 'Item not found.');
    }
    

    public function sortTrash($sort)
    {
        if (!auth()->check()) {
            return redirect()->route('faculty-login');
        }

        $facultyDetails = $this->getFacultyDetails();
        $user = auth()->user();
        $facultyAccountId = $user->faculty_account_id;

        // Retrieve data
        $trashedItems = SemestralEnd::where('trashed', 1)
                                    ->where('faculty_id', $facultyAccountId)
                                    ->with('faculty')
                                    ->get();

        // Convert to Philippine Time and sort
        $trashedItems = $trashedItems->map(function ($item) {
            $item->updated_at = \Carbon\Carbon::parse($item->updated_at)->setTimezone('Asia/Manila');
            return $item;
        });

        // Sort the collection
        if ($sort === 'latest') {
            $trashedItems = $trashedItems->sortByDesc('updated_at');
        } elseif ($sort === 'oldest') {
            $trashedItems = $trashedItems->sortBy('updated_at');
        }

        return view('faculty.faculty-trash', compact('facultyDetails', 'trashedItems'));
    }

    public function deleteTrash($id)
    {
        $semestralEnd = SemestralEnd::findOrFail($id);

        $semestralEnd->delete();

        return redirect()->route('faculty.faculty-trash')->with('success', 'Item deleted successfully!');
    }

    //history
    public function showHistoryPage()
    {
         if (!auth()->check()) {
            return redirect()->route('faculty-login');
        }

        $facultyDetails = $this->getFacultyDetails();
        return view('faculty.history', compact('facultyDetails'));
    }

    //storage
    public function showStoragePage()
    { 
        if (!auth()->check()) {
            return redirect()->route('faculty-login');
        }

        $facultyDetails = $this->getFacultyDetails();
        return view('faculty.faculty-storage', compact('facultyDetails'));
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
            'programs' => 'array', 
            'programs.*' => 'string', 
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
            'programs',
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

    if (Auth::guard('web')->attempt($credentials)) {
        $faculty = Auth::guard('web')->user();    

        if ($faculty instanceof FacultyAccount) {
            Log::debug('User is a faculty');

            if (!$faculty->verify_status) {
                Auth::guard('web')->logout();
                return redirect(route('faculty-login'))->with("error", "Your email is not verified. Please verify your email before logging in.");
            }

            if ($faculty->verification_code) {
                Auth::guard('web')->logout();
                return redirect(route('faculty-login'))->with("error", "Your account is not verified. Please verify your email before logging in.");
            }
        }

        Log::debug('Login successful');
        return redirect()->intended(route('faculty.faculty-records')); 
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
