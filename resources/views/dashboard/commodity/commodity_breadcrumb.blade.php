@php
    $url = request()->url() ;
@endphp
    <nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.productmgt.list') }}">Commodity Management</a></li>
      @if($url == route('admin.productmgt.store.view'))
      <li class="breadcrumb-item active" aria-current="page">Add new commodity</li>
      @endif
      @if(($url == route('admin.productmgt.show',['product' => $product->id ?? 0])) ||  ($url == route('admin.productmgt.edit.view',['product' => $product->id ?? 0])))
       <li class="breadcrumb-item active" aria-current="page">{{ ucwords($product->commodity_name) }}</li>
      @endif
      @if(($url == route('admin.commodity_price.list')))
      <li class="breadcrumb-item active" aria-current="page">Commodity Prices</li>
     @endif
     @if(($url == route('admin.commodity_price.list.update.view')))
     <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.commodity_price.list') }}">Commodity Price</a></li>
     <li class="breadcrumb-item active" aria-current="page">Update Commodity Prices</li>
    @endif

    @if(($url == route('admin.commodity.batch_history',['commodity' => $commodity->id ?? 0,'batch' => $batch_no ?? 0])))
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.productmgt.show',['product' => $commodity->id]) }}"> {{ ucwords($commodity->commodity_name) }} </a></li>
       <li class="breadcrumb-item active" aria-current="page">{{ ucwords($batch_no) }}</li>
      @endif
      
      @if ($url == route('admin.commodity_price.price_upload.batch'))
         <li class="breadcrumb-item active" aria-current="page">Price Upload Batches</li>
        
      @endif

      @if ($url == route('admin.commodity_price.price_upload.batch.data',['batch_no' => $batch_no ?? 1]))
    <li class="breadcrumb-item"  aria-current="page"><a href="{{ route('admin.commodity_price.price_upload.batch') }}">Price Upload Batches</a></li>
    <li class="breadcrumb-item active" aria-current="page">Batch Data</li>
      @endif    

    @if ($url == route('admin.commodity_price.purchase_for_user',['commodity' => $commodity->id ?? 1]))
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.productmgt.show',['product' => $commodity->id]) }}"> {{ ucwords($commodity->commodity_name) }} </a></li>
    <li class="breadcrumb-item active" aria-current="page">Purchase for user</li>
      @endif    
    </ol>
   </nav>
