@extends('dashboard.layout')
@section('content')
@include('dashboard.warehouses.warehouse_breadcrumb')
<div class="row">
     
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                 <h4 class="card-title">Search</h4>
               <form action="?">
                 <div class="form-group row">
                   <div class="col-md-10">
                   <input type="text" value="{{ app()->request->keyword }}" name="keyword" id="" placeholder="Search warehouse etc" class="form-control">
                   </div>

                   <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                   </div>
                 </div>
               </form>
            </div>
       </div>
   </div>
</div>
<div class="row">
    @if(auth('admin')->user()->can('add warehouse'))
    <div class="col-md-12">
    <a class="btn btn-sm btn-primary " style="float: right" href="{{ route('admin.warehousemgt.add_warehouse.view') }}"><i class="mdi mdi-plus-circle-outline"></i> Add new warehouse</a>
    </div>
    @endif
</div>
<br>

<div class="row">

    <div class="col-lg-12 ">
      
        <div class="row">
            @forelse ($warehouses as $warehouse)
            <div class="col-md-4 grid-margin " >
               
                <div class="card">
                    <div class="card-body" style="height : 250px">
                       
                        <div class="d-lg-flex flex-row text-center text-lg-left">
                        <img src="{{ asset('storage/'.$warehouse->warehouse_image) }}" class="img-lg rounded" alt="image">
                            <div class="ml-lg-3">
                            <h6>{{ $warehouse->warehouse_name }}</h6>
                            <p class="text-muted">  {{ $warehouse->city }}</p>
                                <p class="mt-2 text-success font-weight-bold">{{ $warehouse->state }} State</p>
                                
                                @if(auth('admin')->user()->can('view warehouse'))
                                     <a href="{{ route('admin.warehousemgt.show_warehouse',['warehouse' => $warehouse->id]) }}" class="mt-2 text-dark font-weight-bold">view warehouse</a>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
               
            </div>
            @empty
                <div class="row justify-content-center" style="margin: 0 auto">
                    <p>No warehouse added yet</p>
                </div>
            @endforelse
           
          
          
        </div>
        <div style="float: right">
            {!!  $warehouses->links('dashboard.pagination')  !!}

        </div>
    </div>
</div>

@endsection