<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Bahranda Admin</title>

  <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
 
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/custom.css">
  <meta content="{{ csrf_token() }}" name="csrf-token">
  <link rel="shortcut icon" href="/images/favicon.png" />
  @stack('app_css')

</head>

<body class="boxed-layout">
  <div class="container-scroller">
   
     @include('dashboard.topnav')
    <div class="container-fluid page-body-wrapper">
      <div class="row row-offcanvas row-offcanvas-right">
          <div  class="settings-panel">
            <div class="tab-content">
            </div>
        </div>

      @include('dashboard.sidebar')
     
        <div class="content-wrapper">
          {{-- <div class="alert alert-danger"> --}}
         {{-- <marquee behavior="" direction="">Rice Buy ₦2,500/ Sell ₦3,000 | Cocoa Buy ₦3,000/ Sell ₦3,200 | Onion Buy ₦1,000/ Sell ₦2,300 | Rice Buy ₦2,500/ Sell ₦3,000 | Cocoa Buy ₦3,000/ Sell ₦3,200 | Onion Buy ₦1,000/ Sell ₦2,300</marquee> --}}

          {{-- </div> --}}
          @yield('content')
					<footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2020 <a href="#">Bahranda</a>. All rights reserved.</span>
             
            </div>
          </footer>
				
        </div>
     
      </div>
      
    </div>
    
  </div>
  

  <script src="/vendors/js/vendor.bundle.base.js"></script>
  <script src="/js/misc.js"></script>
  <script src="/js/hoverable-collapse.js"></script>

  <script src="/js/off-canvas.js"></script>
  <script src="/js/hoverable-collapse.js"></script>
  @stack('app_js')
</body>


</html>
