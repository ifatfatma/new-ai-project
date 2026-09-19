<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <!-- Brand Logo Area -->
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo text-decoration-none d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
      @if(auth()->user() && auth()->user()->logo)
        <img src="{{ asset(auth()->user()->logo) }}" alt="Logo" class="me-2" style="height: 30px; width: auto; max-width: 90px; object-fit: contain;">
      @else
        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-weight: bold; font-size: 13px;">
          {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
      @endif
      <span style="font-size: 14px; font-weight: 700; color: #FFFFFF; letter-spacing: 0.3px;">
        AI Prompt Hub
      </span>
    </a>
    
    <!-- Mini Logo for collapsed sidebar -->
    <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
      @if(auth()->user() && auth()->user()->logo)
        <img src="{{ asset(auth()->user()->logo) }}" alt="Logo" style="max-height: 30px; object-fit: contain;">
      @else
        <span class="text-white fw-bold">AI</span>
      @endif
    </a>
  </div>

  <!-- Navbar Menu Wrapper -->
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between flex-grow-1 px-3">
    
    <!-- Left Side: Help Number -->
    <div class="d-flex align-items-center">
      <span class="fw-bold text-dark text-nowrap" style="font-size: 13px;">Help : +91 8240112233</span>
    </div>

    <!-- Right Side: Search, Icons & Profile -->
    <ul class="navbar-nav navbar-nav-right ms-auto d-flex align-items-center mb-0 gap-3" style="list-style: none;">

      <!-- Search Field -->
      <li class="nav-item d-none d-md-block">
        <form class="search-form" action="#">
          <input type="search" class="form-control" placeholder="Search Here" style="height: 35px; width: 140px;">
        </form>
      </li>

      <!-- Notification Bell Icon -->
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator text-dark p-0" href="#">
          <i class="mdi mdi-bell-outline" style="font-size: 20px;"></i>
        </a>
      </li>

      <!-- Mail Icon -->
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator text-dark p-0" href="#">
          <i class="mdi mdi-email-outline" style="font-size: 20px;"></i>
        </a>
      </li>

      <!-- Globe (Live Website) Icon -->
      <li class="nav-item">
        <a class="nav-link text-dark p-0" href="{{ url('/') }}" target="_blank" title="Visit Live Website">
          <i class="mdi mdi-earth" style="font-size: 20px;"></i>
        </a>
      </li>

      <!-- User Profile Dropdown -->
      <li class="nav-item dropdown" id="userProfileDropdownContainer">
        <a class="nav-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none p-0" id="profileDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if(auth()->user() && auth()->user()->profile_image)
                <img class="rounded-circle me-2 shadow-sm" src="{{ asset(auth()->user()->profile_image) }}" alt="Profile" style="width: 32px; height: 32px; object-fit: cover;">
            @else
                <img class="rounded-circle me-2 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=0D6EFD&color=fff" alt="Profile" style="width: 32px; height: 32px; object-fit: cover;">
            @endif
            <span class="fw-bold" style="font-size: 14px;">{{ auth()->user()->name ?? 'Admin' }}</span>
        </a>
        
        <!-- Dropdown Card -->
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown p-3 shadow-lg border-0" aria-labelledby="profileDropdown" style="min-width: 220px;">
            <div class="text-center pb-3 border-bottom mb-2">
                @if(auth()->user() && auth()->user()->profile_image)
                    <img class="rounded-circle mb-2 shadow-sm" src="{{ asset(auth()->user()->profile_image) }}" alt="Profile" style="width: 60px; height: 60px; object-fit: cover;">
                @else
                    <img class="rounded-circle mb-2 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=0D6EFD&color=fff" alt="Profile" style="width: 60px; height: 60px; object-fit: cover;">
                @endif
                <h6 class="mb-0 fw-bold">{{ auth()->user()->name ?? 'Admin User' }}</h6>
                <small class="text-muted">{{ auth()->user()->email ?? 'admin@aiprompthub.com' }}</small>
            </div>
            
            <a class="dropdown-item py-2 rounded" href="{{ route('admin.settings.index') }}">
                <i class="mdi mdi-cog-outline text-primary me-2"></i> Settings
            </a>
            
            <div class="dropdown-divider"></div>
            
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="dropdown-item py-2 text-danger rounded border-0 bg-transparent w-100 text-start">
                    <i class="mdi mdi-power text-danger me-2"></i> Log Out
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

<!-- Script to handle clicking outside to close dropdown -->
<script>
  document.addEventListener('click', function (event) {
    const dropdownContainer = document.getElementById('userProfileDropdownContainer');
    if (dropdownContainer) {
      const isClickInside = dropdownContainer.contains(event.target);
      const dropdownMenu = dropdownContainer.querySelector('.dropdown-menu');
      const dropdownToggle = dropdownContainer.querySelector('.dropdown-toggle');
      
      if (!isClickInside && dropdownMenu.classList.contains('show')) {
        // Close dropdown if clicked outside
        dropdownMenu.classList.remove('show');
        dropdownToggle.setAttribute('aria-expanded', 'false');
      }
    }
  });
</script>