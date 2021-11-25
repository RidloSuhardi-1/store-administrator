<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>ELNino Admin | {{ $title }}</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ url('assets/img/brand/favicon.png"') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="{{ url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700') }}">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ url('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ url('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
  <!-- Page plugins -->
  <link rel="stylesheet" href="{{ url('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ url('assets/css/bootstrap-select.min.css') }}">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ url('assets/css/argon.min23cd.css?v=1.2.1') }}" type="text/css">
</head>

<body>
  <!-- Sidenav -->
  @include('dashboard.partials.sidebar')

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('dashboard.partials.topbar')

    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Default</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Content -->
        @yield('page-content')
        <!-- Footer -->
        <footer class="footer pt-0">
            <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6">
                <div class="copyright text-center  text-lg-left  text-muted">
                    Template by &copy; 2021 <a href="https://www.creative-tim.com/" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>, Developed By <a href="https://github.com/RidloSuhardi-1" class="font-weight-bold ml-1" target="_blank">Ridlo Suhardi</a>
                </div>
            </div>
            </div>
        </footer>
    </div>

    <!-- Modal -->
    @yield('page-modal')
    <!-- End Modal -->

  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ url('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ url('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ url('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ url('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ url('assets/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ url('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
  <script src="{{ url('assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
  <script src="{{ url('assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ url('assets/js/argon.min23cd.js?v=1.2.1') }}"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="{{ url('assets/js/demo.min.js') }}"></script>
  <!-- User JS -->
  @yield('page-js')

</body>
</html>
