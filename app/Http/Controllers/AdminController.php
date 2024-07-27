<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
use App\Models\AdminAccount;
use App\Models\FacultyAccount;
use App\Models\SemestralEnd;
use App\Models\YearSemestralFolder;
use App\Models\Announcement;


class AdminController extends Controller
{
    public function showLoginPage()
    {
        return view('admin-login');
    }

    //Show Admin Home
    public function showHomePage()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }
    
        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);
    
        $totalFacultyUsers = FacultyAccount::count();
    
        return view('admin.admin-home', [
            'adminName' => $admin->name,
            'totalFacultyUsers' => $totalFacultyUsers
        ]);
    }
    
    public function showRecordPage()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }

        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);

        $adminName = $admin->name;
        $folders = SemestralEnd::where('trashed', false)->orderBy('created_at', 'desc')->get(); 

        return view('admin.admin-records', compact('folders', 'adminName'));
    }

    //admin year semestral - records
    public function createYearSemestral(Request $request)
    {
        try {
            $request->validate([
                'folderName' => 'required|string|max:255',
            ]);
    
            $user = Auth::user();
    
            if (!$user) {
                throw new \Exception('Authentication required');
            }
    
            $folder = new SemestralEnd();
            $folder->file_name = $request->folderName;
    
            if ($user instanceof FacultyAccount) {
                $folder->faculty_id = $user->faculty_account_id;
            } elseif ($user instanceof AdminAccount) {
                $folder->admin_id = $user->id; // Assuming AdminAccount uses 'id' as the primary key
            } else {
                throw new \Exception('Invalid user type');
            }
    
            $folder->save();
    
            Session::flash('success', 'Folder created successfully!');
    
            return response()->json([
                'success' => true,
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
            $folder->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error deleting folder: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    //open year ends folder
    public function openYearEndsFolder($id)
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }
    
        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);
    
        $adminName = $admin->name;
    
        $folder = SemestralEnd::find($id);
    
        if (!$folder) {
            return redirect()->back()->with('error', 'Folder not found.');
        }

        $folders = YearSemestralFolder::where('semestral_id', $id)->get();
    
        return view('admin.records.folder-semestral-ends', [
            'folder' => $folder,
            'file_name' => $folder->file_name,
            'folders' => $folders,
            'adminName' => $adminName
        ]);
    }
    
    
    public function createFolderSemestralEnds(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'folderName' => 'required|string|max:255',
                'semestralId' => 'required|integer|exists:semestral_end,semestral_id',
            ]);
    
            $user = Auth::guard('admin')->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated user.'
                ], 401);
            }
    
            $currentSemestralEnd = SemestralEnd::findOrFail($validatedData['semestralId']);
    
            $folders = new YearSemestralFolder();
            $folders->folder_name = $validatedData['folderName'];
            $folders->semestral_id = $currentSemestralEnd->semestral_id;
            $folders->admin_id = $user->id;
    
            $folders->save();
    
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

     //edit folder year ends
     public function editYearEndFolder(Request $request, $id)
     {
         try {
             \Log::info('Editing folder with ID: ' . $id);
             \Log::info('Request data: ' . json_encode($request->all()));
             
             $folder = YearSemestralFolder::where('year_semestral_folders_id', $id)->firstOrFail();
             \Log::info('Found folder: ' . json_encode($folder));
             
             $folder->folder_name = $request->name;
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
     public function deleteYearEndFolder($id)
     {
         try {
             $folder = YearSemestralFolder::where('year_semestral_folders_id', $id)->firstOrFail();
             $folder->delete();
             return response()->json(['success' => true]);
         } catch (\Exception $e) {
             \Log::error('Error deleting folder: ' . $e->getMessage());
             return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
         }
     }

     //third records
     public function openFolders($id)
     {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }
    
        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);

        $adminName = $admin->name;
        $folder = YearSemestralFolder::find($id);
        
        if (!$folder) {
            return redirect()->back()->with('error', 'Folder not found.');
        }
        
        return view('admin.records.records', [
            'folder' => $folder,
            'adminName' => $adminName
    ]);


        return view('admin.records.records');
     }
     
     public function showRecordOnePage()
     {
         if (!auth()->guard('admin')->check()) {
             return redirect()->route('admin-login');
         }
     
         $adminId = auth()->guard('admin')->id();
         $admin = \App\Models\AdminAccount::find($adminId);

         $adminName = $admin->name;
     
         return view('admin.records.records_1', ['adminName' => $adminName]);
     }
     
     public function showTestAdministrationPage()
     {
         if (!auth()->guard('admin')->check()) {
             return redirect()->route('admin-login');
         }
     
         $adminId = auth()->guard('admin')->id();
         $admin = \App\Models\AdminAccount::find($adminId);
     
         $adminName = $admin->name;
     
         return view('admin.test-administration.test-administration', ['adminName' => $adminName]);
     }
     
     public function showBsitPage()
     {
         if (!auth()->guard('admin')->check()) {
             return redirect()->route('admin-login');
         }
     
         $adminId = auth()->guard('admin')->id();
         $admin = \App\Models\AdminAccount::find($adminId);
     
         $adminName = $admin->name;
     
         return view('admin.test-administration.bsit', ['adminName' => $adminName]);
     }
     
     public function getFacultyData()
     {
         return \App\Models\FacultyPersonalDetails::select('first_name', 'last_name', 'id_number', 'department', 'employee_type')
             ->get();
     }
     
     //Show User Page
     public function showUsersPage()
     {
         if (!auth()->guard('admin')->check()) {
             return redirect()->route('admin-login');
         }
     
         $adminId = auth()->guard('admin')->id();
         $admin = \App\Models\AdminAccount::find($adminId);
     
         $adminName = $admin->name;
     
         $availableYears = \App\Models\FacultyAccount::selectRaw('YEAR(created_at) as year')
             ->distinct()
             ->pluck('year');
     
         $facultyData = $this->getFacultyData(); 
     
         return view('admin.users', [
             'adminName' => $adminName,
             'availableYears' => $availableYears,
             'facultyData' => $facultyData
         ]);
     }
     
     //Show Access Control Page
     public function showAccessControlPage()
     {
         if (!auth()->guard('admin')->check()) {
             return redirect()->route('admin-login');
         }
     
         $adminId = auth()->guard('admin')->id();
         $admin = \App\Models\AdminAccount::find($adminId);
     
         $adminName = $admin->name;
     
         return view('admin.access-control', ['adminName' => $adminName]);
     }
     
     // Show Trash Page
     public function showTrashPage()
     {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }

        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);
     
        $adminName = $admin->name;
     
         return view('admin.trash', ['adminName' => $adminName]);
     }
     
     // Show History Page
     public function showHistoryPage()
     {
         if (!auth()->guard('admin')->check()) {
             return redirect()->route('admin-login');
         }
    
         $adminId = auth()->guard('admin')->id();
         $admin = \App\Models\AdminAccount::find($adminId);
     
         $adminName = $admin->name;
     
         return view('admin.history', ['adminName' => $adminName]);
     }
     

    // Show Announcement Page
    public function showAnnouncementPage()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }
    
        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);
    
        $adminName = $admin->name;
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
    
        return view('admin.announcement.admin-announcement', [
            'announcements' => $announcements,
            'adminName' => $adminName
        ]);
    }
    
    //Show Add Announcement Page
    public function showAddAnnouncementPage()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }
    
        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);
    
        $adminName = $admin->name;
    
        return view('admin.announcement.add-announcement', ['adminName' => $adminName]);
    }
    
    
    // Save the Announcement
    public function saveAnnouncement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'announcement_subject' => 'required',
            'announcement_message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $announcement = new Announcement();
        $announcement->subject = $request->input('announcement_subject');
        $announcement->message = $request->input('announcement_message');
        $announcement->published = false; 
        $announcement->save();

        $request->session()->flash('success', 'Announcement Added Successfully!');
        return redirect()->route('admin.announcement.admin-announcement');
    }

    // Edit Page
    public function showEditPage()
    {
        return view('admin.announcement.edit-announcement');
    }

    // Display the edit form
    public function editAnnouncement($id_announcement)
    {
       $announcement = Announcement::findOrFail($id_announcement);
       return view('admin.announcement.edit-announcement', compact('announcement'));
    }

    // Update the announcement
    public function updateAnnouncement(Request $request, $id_announcement)
    {
        $validator = Validator::make($request->all(), [
            'announcement_subject' => 'required',
            'announcement_message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $announcement = Announcement::findOrFail($id_announcement);
        $announcement->subject = $request->input('announcement_subject');
        $announcement->message = $request->input('announcement_message');
        $announcement->save();

        $request->session()->flash('success', 'Announcement Updated Successfully!');
        return redirect()->route('admin.announcement.edit-announcement', $id_announcement); 
    }

    //Delete the Announcement
    public function deleteAnnouncement($id_announcement)
    {
        $announcement = Announcement::findOrFail($id_announcement);
        $announcement->delete();
    
        return response()->json(['success' => 'Announcement deleted successfully.']);
    }

    // Publish and Unpublish the announcement
    public function publishAnnouncement($id_announcement)
    {
        $announcement = Announcement::findOrFail($id_announcement);
        $announcement->published = true;
        $announcement->save();
    
        return redirect()->back()->with('success', 'Announcement published successfully!');
    }
    
    public function unpublishAnnouncement($id_announcement)
    {
        $announcement = Announcement::findOrFail($id_announcement);
        $announcement->published = false;
        $announcement->save();
    
        return redirect()->back()->with('success', 'Announcement unpublished successfully!');
    }
    
    //Show Storage Page
    public function showStoragePage()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }

        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);

        $adminName = $admin->name;
        
        return view('admin.admin-storage', ['adminName' => $adminName]);
    }


    //Show Profile Page
    public function showProfilePage()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin-login');
        }
    
        $adminId = auth()->guard('admin')->id();
        $admin = \App\Models\AdminAccount::find($adminId);
    
        $adminName = $admin->name;
    
        return view('admin.admin-profile', ['adminName' => $adminName]);
    }
    
    //login
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
