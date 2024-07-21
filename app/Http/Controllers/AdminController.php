<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
use App\Models\AdminAccount;

class AdminController extends Controller
{
    public function showLoginPage()
    {
        return view('admin-login');
    }

    public function showHomePage()
    {
        return view('admin.admin-home');
    }

    public function showRecordPage()
    {
        return view('admin.admin-records');
    }

    public function showRecordOnePage()
    {
        return view('admin.records.records_1');
    }

    public function showTestAdministrationPage()
    {
        return view('admin.test-administration.test-administration');
    }

    public function showBsitPage()
    {
        return view('admin.test-administration.bsit');
    }

    public function showUsersPage()
    {
        return view('admin.users');
    }
    
    public function showAccessControlPage()
    {
        return view('admin.access-control');
    }

    public function showTrashPage()
    {
        return view('admin.trash');
    }

    public function showHistoryPage()
    {
        return view('admin.history');
    }

    public function showStoragePage()
    {
        return view('admin.storage');
    }

    public function showProfilePage()
    {
        return view('admin.admin-profile');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        Log::debug('Login attempt for:', ['email' => $credentials['email']]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();    
            Log::debug('Login successful for:', ['email' => $admin->email]);
            return redirect()->intended(route('admin.admin-home'));
        }

        Log::debug('Login failed for:', ['email' => $credentials['email']]);
        return redirect()->route('admin-login')->with("error", "Incorrect email address or password. Please try again.");
    }
}
