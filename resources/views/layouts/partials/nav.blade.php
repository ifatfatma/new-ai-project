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

    <!-- Categories CRUD -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.categories.index') }}">
        <i class="menu-icon mdi mdi-folder-outline"></i>
        <span class="menu-title">Categories</span>
      </a>
    </li>

    <!-- All Prompts List -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.prompts.index') }}">
        <i class="menu-icon mdi mdi-format-list-bulleted"></i>
        <span class="menu-title">All Prompts</span>
      </a>
    </li>

    <!-- Add New Prompt -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.prompts.create') }}">
        <i class="menu-icon mdi mdi-plus-box-outline"></i>
        <span class="menu-title">Add New Prompt</span>
      </a>
    </li>

    
      </a>
      <div class="collapse" id="categoryQuickMenu">
        <ul class="nav flex-column sub-menu ps-3 py-2">
          @foreach(\App\Models\Category::all() as $category)
            <li class="nav-item mb-1">
              <a class="nav-link py-1 text-muted" href="{{ route('admin.categories.index') }}">
                <i class="mdi mdi-circle-small me-1"></i> {{ $category->name }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </li>

  </ul>
</nav>