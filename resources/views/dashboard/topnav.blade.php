 <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-success">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="#"><img src="/images/logo.png" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="#">B</a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav">
        
        </ul>
        <ul class="navbar-nav navbar-nav-right">
        
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <a class="dropdown-item">
                <p class="mb-0 font-weight-normal float-left">You have 0 new notifications
                </p>
                <span class="badge badge-pill badge-warning float-right"></span>
              </a>
        
          </li>
        
          <li class="nav-item nav-settings d-none d-lg-block dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="profileDropDown" href="#" data-toggle="dropdown">
              <i class="icon-user"></i>
            </a>
             <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropDown">
               
             <a class="dropdown-item" href="{{ route('admin.adminmgt.show',['admin' => auth('admin')->user()->id]) }}">
                        <i class="icon-user"></i>
                       Profile
                       
                    </a>
                    <div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item">
                        <i class="icon-settings"></i>  Settings
                    </a> --}}
                    <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('admin.logout') }}">
                       
                        <i class="icon-power"></i>
                        Logout
                    </a>
             </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>