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
    <ul class="navbar-nav ms-auto d-flex align-items-center justify-content-end gap-3" style="margin-right: 0 !important;">
      
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
      <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="img-xs rounded-circle me-2" src="{{ asset('admin/assets/images/faces/face8.jpg') }}" alt="Profile image"> 
          <span class="font-weight-semibold">Admin</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
            <img class="img-md rounded-circle" src="{{ asset('admin/assets/images/faces/face8.jpg') }}" alt="Profile image">
            <p class="mb-1 mt-3 font-weight-semibold">Admin User</p>
            <p class="font-weight-light text-muted mb-0">admin@aiprompthub.com</p>
          </div>
          
          <!-- Dropdown Options -->
          <a class="dropdown-item" href="#">
            <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile
          </a>
          <a class="dropdown-item" href="#">
            <i class="dropdown-item-icon mdi mdi-cog-outline text-primary me-2"></i> Settings
          </a>
          
          <hr class="dropdown-divider">

          <!-- Logout Action -->
          <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="dropdown-item text-danger font-weight-bold py-2" style="background: none; border: none; cursor: pointer; width: 100%; text-align: left;">
              <i class="dropdown-item-icon mdi mdi-power text-danger me-2"></i> Log Out
            </button>
          </form>
        </div>
      </li>

    </ul>

    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>