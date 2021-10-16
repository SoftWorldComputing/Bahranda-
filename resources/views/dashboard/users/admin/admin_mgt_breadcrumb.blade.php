@php
    $url = request()->url() ;
@endphp
    <nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.adminmgt.list') }}">Admin Management</a></li>
      @if($url == route('admin.adminmgt.show',['admin' => $admin->id ?? 'null']))
        <li class="breadcrumb-item active" aria-current="page">{{ ucwords($admin->name) }}</li>
      @endif

      @if($url == route('admin.admin_mgt.store.view'))
        <li class="breadcrumb-item active" aria-current="page">Add new admin</li>
      @endif
      
    </ol>
   </nav>
