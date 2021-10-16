@php
    $url = request()->url() ;
@endphp
    <nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.warehousemgt.list') }}">Warehouse Management</a></li>
      @if ($url == route('admin.warehousemgt.add_warehouse.view'))
        
        <li class="breadcrumb-item active" aria-current="page">Add Warehouse</li>
      @endif
       
      @if ($url == route('admin.warehousemgt.show_warehouse',['warehouse' => $warehouse->id ?? 0]))
        
         <li class="breadcrumb-item active" aria-current="page">{{ $warehouse->warehouse_name }}</li>
      @endif

      @if ($url == route('admin.warehousemgt.checkout.view',['warehouse' => $warehouse->id ?? 0]))
        
          <li class="breadcrumb-item active" aria-current="page">{{ $warehouse->warehouse_name }}</li>
      @endif

      @if ($url == route('admin.warehousemgt.checkout.requests.all'))
           <li class="breadcrumb-item active" aria-current="page">Warehouse checkouts</li>
          
      @endif
      @if ($url == route('admin.warehousemgt.checkout.requests.all.data',['batch_no' => $batch_no ?? 0]))
         <li class="breadcrumb-item " aria-current="page"><a href="{{ route('admin.warehousemgt.checkout.requests.all') }}">Warehouse checkouts</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{  $batch_no  }}</li>
     
     @endif
     
      
    </ol>
   </nav>
