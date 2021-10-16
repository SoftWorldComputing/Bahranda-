@php
    $url = request()->url() ;
@endphp
    <nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.rolemgt.list') }}">Role Management</a></li>
       @if($url == route('admin.rolemgt.view',['role' => $role->name ?? 'null']))
        <li class="breadcrumb-item active" aria-current="page">{{ $role->display_name }}</li>
      @endif
      @if($url == route('admin.rolemgt.create-role.view'))
       <li class="breadcrumb-item active" aria-current="page">Add Role</li>
      @endif
      
    </ol>
   </nav>
