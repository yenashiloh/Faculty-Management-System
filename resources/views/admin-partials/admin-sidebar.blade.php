 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
     <div class="navbar-wrapper">
         <div class="m-header">
             <a href="{{ route('admin.admin-home') }}" class="b-brand text-primary">
                 <div class="logo-container">
                     <img src="{{ asset('assets/images/pup-logo.png') }}" alt="" class="logo logo-lg">
                     <p class="faculty">FARM System</p>
                 </div>
             </a>
         </div>
         <div class="navbar-content">
             <ul class="pc-navbar">
                 <li class="pc-item pc-caption">
                     <label>Dashboard</label>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('admin.admin-home') }}" class="pc-link"><span class="pc-micon"><i
                                 class="fas fa-home"></i></span><span class="pc-mtext">Home</span></a>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('admin.admin-records') }}" class="pc-link">
                         <span class="pc-micon"><i class="fas fa-folder"></i></span>
                         <span class="pc-mtext">Records</span>
                     </a>
                 </li>
                 <li class="pc-item">
                     <a href="{{ route('admin.users') }}" class="pc-link">
                         <span class="pc-micon"><i class="fas fa-users"></i></span>
                         <span class="pc-mtext">Users</span>
                     </a>
                 </li>

                 <li class="pc-item">
                     <a href="{{ route('admin.access-control') }}" class="pc-link">
                         <span class="pc-micon"><i class="fas fa-user-lock"></i></span>
                         <span class="pc-mtext">Access Control</span>
                     </a>
                 </li>

                 <li class="pc-item">
                     <a href="{{ route('admin.trash') }}" class="pc-link">
                         <span class="pc-micon"><i class="fas fa-trash"></i></span>
                         <span class="pc-mtext">Trash</span>
                     </a>
                 </li>

                 <li class="pc-item">
                     <a href="{{ route('admin.history') }}" class="pc-link">
                         <span class="pc-micon"><i class="fas fa-envelope-open"></i></span>
                         <span class="pc-mtext">History</span>
                     </a>
                 </li>

                 <li class="pc-item">
                    <a href="{{ route('admin.admin-storage') }}" class="pc-link">
                        <span class="pc-micon"><i class="fas fa-server"></i></span>
                        <span class="pc-mtext">Storage</span>
                    </a>
                </li>
                

                 <li class="pc-item pc-hasmenu">
                     <a href="#!" class="pc-link"><span class="pc-micon"><i class="fas fa-cogs"></i></span><span
                             class="pc-mtext">Maintenance</span><span class="pc-arrow"><i
                                 data-feather="chevron-right"></i></span></a>
                     <ul class="pc-submenu">
                         <li class="pc-item"><a class="pc-link"
                                 href="{{ route('admin.announcement.admin-announcement') }}">Announcement</a></li>
                         <li class="pc-item"><a class="pc-link" href="#!">Create Account</a></li>
                 </li>
             </ul>

         </div>
     </div>
 </nav>
 <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
 <header class="pc-header">
     <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
         <div class="me-auto pc-mob-drp">
             <ul class="list-unstyled">
                 <li class="pc-h-item header-mobile-collapse">
                     <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
                         <i class="ti ti-menu-2"></i>
                     </a>
                 </li>
                 <li class="pc-h-item pc-sidebar-popup">
                     <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
                         <i class="ti ti-menu-2"></i>
                     </a>
                 </li>
             </ul>
         </div>


         <!-- [Mobile Media Block end] -->
         <div class="ms-auto">
             <ul class="list-unstyled">
                 <li class="dropdown pc-h-item">
                     <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0"
                         data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                         aria-expanded="false">
                         <i class="fas fa-bell"></i>
                     </a>
                     <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                         <div class="dropdown-header">
                             <a href="#!" class="link-primary float-end text-decoration-underline">Mark as all
                                 read</a>
                             <h5>All Notification <span class="badge bg-warning rounded-pill ms-1">01</span></h5>
                         </div>
                         <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                             style="max-height: calc(100vh - 215px)">
                             <div class="list-group list-group-flush w-100">
                                 <div class="list-group-item list-group-item-action">
                                     <div class="d-flex">
                                         <div class="flex-shrink-0">
                                             <div class="user-avtar bg-light-success"><i class="fas fa-user"></i>
                                             </div>
                                         </div>
                                         <div class="flex-grow-1 ms-1">
                                             <span class="float-end text-muted">3 min ago</span>
                                             <h5>James Nabayra</h5>
                                             <p class="text-body fs-6">requested to download a file.</p>
                                             <div class="badge rounded-pill bg-light-danger">Unread</div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="list-group-item list-group-item-action">
                                     <div class="d-flex">
                                         <div class="flex-shrink-0">
                                             <div class="user-avtar bg-light-success"><i class="fas fa-user"></i>
                                             </div>
                                         </div>
                                         <div class="flex-grow-1 ms-1">
                                             <span class="float-end text-muted">10 min ago</span>
                                             <h5>Diana Rose Fildel</h5>
                                             <p class="text-body fs-6">Delete bsit_1.xsl</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="dropdown-divider"></div>
                         <div class="text-center py-2">
                             <a href="#!" class="link-primary">Mark as all read</a>
                         </div>
                     </div>
                 </li>
                 <li class="dropdown pc-h-item header-user-profile">
                     <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0"
                         data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                         aria-expanded="false">
                         <img src="../../../assets/images/user/user.webp" alt="user-image" class="user-avtar">
                         <span>
                             <i class="fas fa-cog"></i>
                         </span>
                     </a>
                     <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                         <div class="dropdown-header">
                             <h4 class="text-center"><span class="text-muted text-center"
                                     style="font-size: 20px;">{{ $adminName }}</span></h4>
                             <p class="text-muted text-center">Admin</p>
                             <hr class="mb-0 mt-0">
                             <a href="{{ route('admin.admin-profile') }}" class="dropdown-item">
                                 <i class="fas fa-user"></i>
                                 <span>Profile</span>
                             </a>
                             <form action="{{ url('admin-logout') }}" method="POST">
                                 @csrf
                                 <button type="submit" class="dropdown-item">
                                     <i class="fas fa-sign-out-alt"></i>
                                     <span>Log out</span>
                                 </button>
                             </form>
                         </div>
                     </div>
         </div>
         </li>
         </ul>
     </div>
     </div>
 </header>
 <!-- [ Header ] end -->
