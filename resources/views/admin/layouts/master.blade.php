@php
    $routeName = request()->route()->getName();
    $routeGroup = request()->route()->getPrefix();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("backend/plugins/fontawesome-free/css/all.min.css") }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset("backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset("backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("backend/dist/css/adminlte.min.css") }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset("backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
  <link rel="stylesheet" href="{{ asset("backend/plugins/toastr/toastr.min.css") }}">

  {{-- Custom css --}}
  <link rel="stylesheet" href="{{ asset("backend/dist/css/custom.css") }}">
  @yield('extraCss')


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="admin">
  <vue-progress-bar></vue-progress-bar>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu"
         href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      {{-- Notification --}}
      <admin-notification></admin-notification>
      {{-- End --}}

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">
          @if(auth()->user()->photo != "")
          <img class="profile-thumb" src="{{ asset("uploads/admin/profile/".auth()->user()->photo) }}" alt="">
          @else
          <img class="profile-thumb" src="{{ asset("img/portrait-placeholder.png") }}" alt="">
          @endif
        </a>
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <a href="{{ route("profile") }}" class="dropdown-item"><i class="fas fa-user"></i> &nbsp;Profile</a>
          
          @if(auth()->user()->role == "super")
            <a href="{{ route("super.user-list") }}" class="dropdown-item"><i class="fas fa-user-friends"></i> &nbsp;User List</a>
          @endif

          <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> &nbsp;Logout</a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route("admin.home") }}" class="brand-link">
      <img src="{{ asset("backend/dist/img/AdminLTELogo.png") }}" 
      alt="AdminLTE Logo" class="brand-image img-circle elevation-3" 
      style="opacity: .8">
      <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(auth()->user()->photo != "")
          <img src="{{ asset("uploads/admin/profile/".auth()->user()->photo) }}" class="img-circle elevation-2" alt="User Image">
          @else
          <img src="{{ asset("img/portrait-placeholder.png") }}" class="img-circle elevation-2" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> -->


          <li class="nav-header">Dashboard</li>

          <li class="nav-item">
            <a href="{{ route("admin.home") }}" class="nav-link {{ $routeName=='admin.home'?'active':'' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">Database options</li>

          <li class="nav-item {{ $routeGroup=='admin/rss-url'?'menu-open':'' }}">
            <a href="#" class="nav-link {{ $routeGroup=='admin/rss-url'?'active':'' }}">
              <i class="nav-icon fas fa-rss"></i>
              <p>
                RSS Url
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route("rss.add") }}" class="nav-link {{ $routeName=='rss.add'?'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add URL</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route("rss.list") }}" class="nav-link {{ $routeName=='rss.list'?'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rss url List</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-header">User Account</li>

          <li class="nav-item">
            <a href="{{ route('profile') }}" class="nav-link 
            {{ $routeName=='profile'?'active':'' }}">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                My Profile
              </p>
            </a>
          </li>

          @if(auth()->user()->role == "super")
          <li class="nav-item">
            <a href="{{ route("super.user-list") }}" class="nav-link 
            {{ $routeName=='super.user-list'?'active':'' }}">
              <i class="nav-icon fas fa fa-users"></i>
              <p>
                User List <small>(Super Admin)</small>
              </p>
            </a>
          </li>  
          @endif
          


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022</strong>
    All rights reserved.
    <div>
      Developed By <a target="_blank" href="https://www.freelancer.com.bd/u/mdeasinislam6">Md Sazzad</a>
    </div>
  </footer>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset("backend/plugins/jquery/jquery.min.js") }}"></script>
<link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
<script src="{{ asset("js/highlightjs-vue.min.js") }}"></script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
 integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script src="{{ asset("js/app.js") }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset("backend/plugins/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset("backend/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset("backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset("backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("backend/dist/js/adminlte.js") }}"></script>
<script src="{{ asset("backend/plugins/toastr/toastr.min.js") }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("backend/dist/js/demo.js") }}"></script>
@yield('extraJs')
</body>
</html>