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

    <!-- Direct Add Prompt Link -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.prompts.create') }}">
        <i class="menu-icon mdi mdi-plus-box-outline"></i>
        <span class="menu-title">Add New Prompt</span>
      </a>
    </li>

    <!-- Prompt Categories Dropdown -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#categoryMenu" aria-expanded="false" aria-controls="categoryMenu">
        <i class="menu-icon mdi mdi-folder-outline"></i>
        <span class="menu-title">Prompt Categories</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="categoryMenu">
        <ul class="nav flex-column sub-menu">
          @foreach(\App\Models\Category::all() as $category)
            <li class="nav-item">
              <a class="nav-link" href="#">
                {{ $category->name }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </li>

  </ul>
</nav>