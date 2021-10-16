<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <div class="nav-link">
          <div class="profile-image">
          <img src="{{ asset(auth('admin')->user()->image) }}" alt="image"/>
            <span class="online-status online"></span> 
          </div>
          <div class="profile-name">
            <p class="name">
                {{ auth('admin')->user()->name}}
            </p>
            <p class="designation">
             @include('dashboard.role_name')
            </p>
          </div>
        </div>
      </li>
      <li class="nav-item">
      <a class="nav-link " href="{{ route('admin.dashboard.index') }}">
          <i class="icon-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        
        </a>
      </li>
  
     
      <li class="nav-item" id="myuser-mgt">
        <a class="nav-link" data-toggle="collapse" href="#users-mgt" aria-expanded="false" aria-controls="users-mgt">
          <i class="icon-user menu-icon"></i>
          <span class="menu-title">Users</span>
         
        </a>
        <div class="collapse" id="users-mgt">
          <ul class="nav flex-column sub-menu">
            @if(auth('admin')->user()->can('create admin') || auth('admin')->user()->can('view all admin') )
             <li class="nav-item"> <a class="nav-link" data-ref-link="myuser-mgt" href="{{ route('admin.adminmgt.list') }}">Admin</a></li>
            @endif
             <li class="nav-item "> <a class="nav-link" data-ref-link="myuser-mgt" href="{{ route('admin.user_mgt.list') }}">User</a></li>
                
          </ul>
        </div>
      </li>
      @if( auth('admin')->user()->can('list commodity') || auth('admin')->user()->can('commodity price') )
     
      <li class="nav-item" id="myproduct-mgt">
        <a class="nav-link" data-toggle="collapse" href="#product-mgt" aria-expanded="false" aria-controls="product-mgt">
          <i class="icon-basket-loaded menu-icon"></i>
          <span class="menu-title">Commodity</span>
         
        </a>
        <div class="collapse" id="product-mgt">
          <ul class="nav flex-column sub-menu">
            @if( auth('admin')->user()->can('list commodity') )
          <li class="nav-item "> <a class="nav-link" data-ref-link="myproduct-mgt" href="{{ route('admin.productmgt.list') }}">All Commodity</a></li>
          @endif
          @if( auth('admin')->user()->can('commodity price') )
          <li class="nav-item "> <a class="nav-link" data-ref-link="myproduct-mgt" href="{{ route('admin.commodity_price.list') }}"> Commodity Prices</a></li>
      
          
          <li class="nav-item "> <a class="nav-link" data-ref-link="myproduct-mgt" href="{{ route('admin.commodity_price.price_upload.batch') }}"> Price Uploads</a></li>
          @endif
          </ul>
        </div>
      </li>
      @endif
     
      @if( auth('admin')->user()->can('see all warehouse') || auth('admin')->user()->can('checkout warehouse') )
      <li class="nav-item" id="mywarehouse-mgt">
        <a class="nav-link" data-toggle="collapse" href="#warehouse-mgt" aria-expanded="false" aria-controls="warehouse-mgt">
          <i class=" icon-bag menu-icon"></i>
          <span class="menu-title">Warehouses</span>
        </a>
        <div class="collapse" id="warehouse-mgt">
          <ul class="nav flex-column sub-menu">
            @if( auth('admin')->user()->can('see all warehouse'))
              <li class="nav-item "> <a class="nav-link" data-ref-link="warehouse-mgt" href="{{ route('admin.warehousemgt.list') }}">All Warehouses</a>
              </li>
              @endif

              @if( auth('admin')->user()->can('checkout warehouse'))
              <li class="nav-item "> <a class="nav-link" data-ref-link="warehouse-mgt" href="{{ route('admin.warehousemgt.checkout.requests.all') }}">Checkout Requests</a>
              </li>
              @endif
  
          </ul>
        </div>
      </li>
      @endif


      @if( auth('admin')->user()->can('see all deals'))
      <li class="nav-item" id="mypartnership-mgt">
        <a class="nav-link" data-toggle="collapse" href="#partnership-mgt" aria-expanded="false" aria-controls="partnership-mgt">
          <i class="icon-wallet menu-icon"></i>
          <span class="menu-title">Deals</span>
        </a>
        <div class="collapse" id="partnership-mgt">
          <ul class="nav flex-column sub-menu">
              <li class="nav-item "> <a class="nav-link" data-ref-link="partnership-mgt" href="{{ route('admin.partnership.list') }}">All  Deals</a>
              </li>

            <li class="nav-item "> <a class="nav-link" data-ref-link="partnership-mgt" href="{{ route('admin.partnership.by_batch') }}">Deal by Batch</a>
              </li>
  
          </ul>
        </div>
      </li>
   @endif
      
   @if(auth('admin')->user()->can('list accounting'))
   <li class="nav-item">
   <a class="nav-link " href="{{ route('admin.accounting.all_account') }}">
        <i class="icon-chart menu-icon"></i>
        <span class="menu-title">Accounting</span>
      
      </a>
    </li>
  @endif
  @if(auth('admin')->user()->can('withdrawal requests list'))

    <li class="nav-item">
      <a class="nav-link " href="{{ route('admin.accounting.withdrwal.requests.view') }}">
           <i class=" icon-shuffle menu-icon"></i>
           <span class="menu-title">Withdrawals</span>
         
         </a>
       </li>

     @endif
      <li class="nav-item" id="myrole-mgt">
        <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
          <i class="icon-settings menu-icon"></i>
          <span class="menu-title">Settings</span>
         
        </a>
        <div class="collapse" id="page-layouts">
          <ul class="nav flex-column sub-menu">
          @if(auth('admin')->user()->can('view all roles'))

          <li class="nav-item "> <a class="nav-link" data-ref-link="myrole-mgt" href="{{ route('admin.rolemgt.list') }}">Role Management</a></li>
         @endif

         <li class="nav-item "> <a class="nav-link" data-ref-link="myrole-mgt" href="{{ route('admin.settings.site.show') }}">Site Management</a></li>

         <li class="nav-item "> <a class="nav-link" data-ref-link="myrole-mgt" href="{{ route('admin.settings.change_password.view') }}">Change password</a></li>
          </ul>
        </div>

      </li>
      
      <li class="nav-item ">
        <a class="nav-link " href="{{ route('admin.logout') }}">
            <i class=" icon-power menu-icon"></i>
            <span class="menu-title">Logout</span>
          
          </a>
        </li>
     
    </ul>
  </nav>
