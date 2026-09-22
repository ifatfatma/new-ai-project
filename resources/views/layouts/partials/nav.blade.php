<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav" style="margin-top: 15px;">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- Categories & Prompts Dropdown -->
    <li class="nav-item">
      <!-- Agar current route categories ya prompts ka hai, toh 'collapsed' class hata di gayi hai -->
      <a class="nav-link {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.prompts.*') ? '' : 'collapsed' }}" id="categoryToggleBtn" href="javascript:void(0);" style="cursor: pointer;">
        <i class="menu-icon mdi mdi-folder-cog-outline"></i>
        <span class="menu-title">Prompts</span>
        <i class="menu-arrow mdi mdi-chevron-down ms-auto"></i>
      </a>
      
      <!-- Agar current route categories ya prompts ka hai, toh style display block kar diya hai taaki menu khula rahe -->
      <div class="collapse {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.prompts.*') ? 'show' : '' }}" id="manageCategoryMenu" style="{{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.prompts.*') ? 'display: block;' : 'display: none;' }}">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
              <i class="mdi mdi-format-list-bulleted me-2"></i> All Categories
            </a>
          </li>
          <li class="nav-item">
            <!-- Yeh raha aapka All Prompts ka link jo already connected hai -->
            <a class="nav-link {{ request()->routeIs('admin.prompts.*') ? 'active' : '' }}" href="{{ route('admin.prompts.index') }}">
              <i class="mdi mdi-format-list-bulleted me-2"></i> All Prompts
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Settings -->
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
        <svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
          <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h-3.84c-.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
        </svg>
        Settings
      </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
      <a class="nav-link text-danger" href="{{ route('admin.logout') }}" 
         onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
        <i class="mdi mdi-power me-2 text-danger"></i> Log-out
      </a>
    </li>

  </ul>
</nav>

<!-- Hidden Logout Form -->
<form id="logout-form-sidebar" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
  @csrf
</form>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('categoryToggleBtn');
    const targetMenu = document.getElementById('manageCategoryMenu');

    if (toggleBtn && targetMenu) {
      toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        if (targetMenu.style.display === "none" || targetMenu.style.display === "") {
          targetMenu.style.display = "block";
          targetMenu.classList.add('show');
          toggleBtn.classList.remove('collapsed');
        } else {
          targetMenu.style.display = "none";
          targetMenu.classList.remove('show');
          toggleBtn.classList.add('collapsed');
        }
      });
    }
  });
</script>