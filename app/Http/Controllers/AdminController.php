<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
use App\Models\AdminAccount;
use App\Models\SemestralEnd;

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
        $folders = SemestralEnd::orderBy('created_at', 'desc')->get();
        return view('admin.admin-records', compact('folders'));
    }

    //admin year semestral - records
    public function createYearSemestral(Request $request)
    {
        $request->validate([
            'folderName' => 'required|string|max:255',
        ]);
    
        $folder = new SemestralEnd();
        $folder->file_name = $request->folderName;
        $folder->save();
    
        Session::flash('success', 'Folder created successfully!');
    
        return response()->json([
            'success' => true,
            'folder' => $folder
        ]);
    }

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

    public function deleteRecordFolder($id)
    {
        try {
            $folder = SemestralEnd::where('semestral_id', $id)->firstOrFail();
            $folder->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error deleting folder: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
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

    public function showMaintenanceModulePage()
    {
        return view('admin.maintenance-module');
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

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin-login');
    }

   
}
