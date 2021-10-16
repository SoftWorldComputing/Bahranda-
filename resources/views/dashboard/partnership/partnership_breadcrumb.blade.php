@php
    $url = request()->url() ;
@endphp
    <nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.partnership.list') }}">Deal Management</a></li>
       
      @if($url == route('admin.partnership.view_partnership',['partnership' => $partnership->id ?? 0]))
      <li class="breadcrumb-item active" aria-current="page">Deal Information</li>
      @endif

      @if($url == route('admin.partnership.by_batch'))
      <li class="breadcrumb-item active" aria-current="page">Deal By Batches</li>
      @endif
      @if($url == route('admin.partnership.batch_deals',['batch_no' => $batch_no ?? 0]))
       <li class="breadcrumb-item " aria-current="page"> <a href="{{ route('admin.partnership.by_batch') }}">Deal By Batches</a> </li>

        <li class="breadcrumb-item active" aria-current="page">{{ $batch_no }} </li>
      @endif

    

    </ol>
   </nav>
