@php
    $url = request()->url() ;
@endphp
    <nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
      @if(app()->request->keyword || app()->request->date_from || app()->request->date_to  )
         <li class="breadcrumb-item"  aria-current="page"><a href="{{ route('admin.accounting.all_account') }}">Accounting</a></li>
         <li class="breadcrumb-item active"  aria-current="page"><a href="">Search</a></li>

      @else 
      <li class="breadcrumb-item active"  aria-current="page"><a href="#">Accounting</a></li>


      @endif
    
       
      
    </ol>
   </nav>
