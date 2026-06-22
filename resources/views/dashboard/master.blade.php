<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}" />

   <style>
  .content-wrapper {
    padding: 1.5rem 1rem !important; 
    width: 100%;
    overflow: visible; 
    background-color: #FDFBF7 !important; /* Soft warm beige */
  }

  body, .main-panel, .page-body-wrapper, .sidebar {
    background-color: #FDFBF7 !important;
    font-family: "Inter", "Segoe UI", system-ui, sans-serif;
  }

  .main-panel {
    transition: width 0.3s ease;
    width: 100% !important;
    min-height: calc(100vh - 60px);
    display: flex;
    flex-direction: column;
  }

  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  /* Elegant Card Styling */
  .card {
      border: 1px solid #F5F0E6 !important; 
      border-radius: 1rem !important; 
      box-shadow: 0 10px 30px rgba(94, 69, 53, 0.06) !important; 
      background-color: #ffffff !important;
      transition: all 0.3s ease;
  }
  
  /* Text Colors */
  h1, h2, h3, h4, h5, .card-title {
      color: #3E2723 !important; /* Rich dark brown */
      font-weight: 700;
  }
  p, small, .text-muted, td, th {
      color: #8D6E63 !important; 
  }

  /* Table styling */
  .table thead th {
      background-color: #EFEBE0 !important;
      border-bottom: 2px solid #D7CCC8 !important;
      color: #5D4037 !important;
  }
  .table-hover tbody tr:hover {
      background-color: #FDFBF7 !important;
  }

  /* Button Styling */
  .btn-primary {
      background-color: #5D4037 !important;
      border-color: #5D4037 !important;
      color: #ffffff !important;
      border-radius: 0.5rem;
  }
  .btn-primary:hover {
      background-color: #3E2723 !important;
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(93, 64, 55, 0.2) !important;
  }
  
  /* Sidebar Links */
  .sidebar .nav .nav-item.active > .nav-link {
      background-color: #EFEBE0 !important;
      color: #5D4037 !important;
      border-radius: 0 20px 20px 0;
  }
  .sidebar .nav .nav-item .nav-link i.menu-icon {
      color: #8D6E63 !important;
  }
  .sidebar .nav .nav-item.active > .nav-link i.menu-icon {
      color: #5D4037 !important;
  }
  .sidebar .nav .nav-item .nav-link:hover {
      background-color: #FDFBF7 !important;
  }
</style>
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
      @include('dashboard.header')
      
      <div class="container-fluid page-body-wrapper">
        @include('dashboard.sedebar')

        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          @include('dashboard.footer')
        </div>
      </div>
    </div>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{ asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{ asset('assets/js/template.js')}}"></script>
    <script src="{{ asset('assets/js/settings.js')}}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{ asset('assets/js/todolist.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dashboard.js')}}"></script>
    @stack('scripts')
  </body>
</html>