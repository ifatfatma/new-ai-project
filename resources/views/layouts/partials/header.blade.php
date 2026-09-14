<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <!-- Brand Logo Area -->
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="#">
      <span style="font-size: 20px; font-weight: 800; color: #FFFFFF; letter-spacing: 0.5px;">
        AI Prompt Hub
      </span>
    </a>
  </div>

  <!-- Navbar Menu Wrapper -->
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">

    <!-- Left Side: Help Number -->
    <div class="d-flex align-items-center">
      <span class="fw-bold">Help : +91 8240112233</span>
    </div>

    <!-- Right Side: Search, Bell, Mail, Globe & Profile -->
    <ul class="navbar-nav ms-auto d-flex align-items-center justify-content-end gap-3"
      style="margin-right: 0 !important;">

      <!-- Search Field -->
      <li class="nav-item">
        <form class="search-form" action="#">
          <input type="search" class="form-control" placeholder="Search Here" style="height: 38px;">
        </form>
      </li>

      <!-- Notification Bell Icon -->
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator" href="#">
          <i class="mdi mdi-bell-outline" style="font-size: 20px;"></i>
        </a>
      </li>

      <!-- Mail Icon -->
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator" href="#">
          <i class="mdi mdi-email-outline" style="font-size: 20px;"></i>
        </a>
      </li>

      <!-- Globe (Live Website) Icon -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}" target="_blank" title="Visit Live Website">
          <i class="mdi mdi-earth" style="font-size: 20px;"></i>
        </a>
      </li>

      <!-- User Profile Dropdown -->
   <li class="nav-item dropdown">
    <!-- Dropdown Toggle Button -->
    <a class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" href="javascript:void(0);" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
        <img class="img-xs rounded-circle me-2" src="https://ui-avatars.com/api/?name=Admin+User&background=0D6EFD&color=fff" alt="Profile image" style="width: 35px; height: 35px; object-fit: cover;">
        <span class="font-weight-bold ms-1">Admin</span>
    </a>
    
    <!-- Dropdown Card -->
    <div class="dropdown-menu dropdown-menu-end navbar-dropdown p-3 shadow-lg border-0" aria-labelledby="profileDropdown" style="min-width: 250px;">
        <div class="text-center pb-3 border-bottom mb-2">
            <img class="img-md rounded-circle mb-2" src="https://ui-avatars.com/api/?name=Admin+User&background=0D6EFD&color=fff" alt="Profile image" style="width: 70px; height: 70px; object-fit: cover;">
            <h6 class="mb-0 font-weight-bold">Admin User</h6>
            <small class="text-muted">admin@aiprompthub.com</small>
        </div>
        
        <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
            <i class="mdi mdi-account-outline text-primary me-2"></i> My Profile
        </a>
        
        <a class="dropdown-item py-2" href="#">
            <i class="mdi mdi-cog-outline text-primary me-2"></i> Settings
        </a>
        
        <div class="dropdown-divider"></div>
        
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="dropdown-item py-2 text-danger">
                <i class="mdi mdi-power text-danger me-2"></i> Log Out
            </button>
        </form>
    </div>
</li>

    </ul>

    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>