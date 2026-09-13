<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item nav-category">Management</li>

    <!-- Categories Dropdown Menu -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#manageCategoryMenu" aria-expanded="false" aria-controls="manageCategoryMenu">
        <i class="menu-icon mdi mdi-folder-cog-outline"></i>
        <span class="menu-title">Categories</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="manageCategoryMenu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
              <i class="mdi mdi-format-list-bulleted me-2"></i> All Categories
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.prompts.index') }}">
              <i class="mdi mdi-text-box-multiple-outline me-2"></i> All Prompts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.prompts.create') }}">
              <i class="mdi mdi-plus-box-outline me-2"></i> Add New Prompt
            </a>
          </li>
        </ul>
      </div>
    </li>

  </ul>
</nav>