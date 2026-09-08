<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard - AI Prompt Project</title>

  <!-- CSS Partials -->
  @include('layouts.partials.css')
</head>
<body>
  <div class="container-scroller">
    <!-- Top Header/Navbar Partial -->
    @include('layouts.partials.header')

    <div class="container-fluid page-body-wrapper">
      <!-- Left Sidebar Partial -->
      @include('layouts.partials.nav')

      <div class="main-panel">
        <div class="content-wrapper">
          <!-- Dynamic Content Area -->
          @yield('content')
        </div>
        <!-- content-wrapper ends -->

        <!-- Footer Partial -->
        @include('layouts.partials.footer')
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- JS Partials -->
  @include('layouts.partials.js')
</body>
</html>