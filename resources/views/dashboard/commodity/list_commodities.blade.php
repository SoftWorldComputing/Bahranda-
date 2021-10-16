@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')
 <div class="row">
    <div class="col-md-6 grid-margin">
        <div class="card">
           <div class="card-body">
            <h6 class="card-title mb-0">Active Commodity</h6>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-inline-block pt-3">
                <div class="d-lg-flex">
                <h2 class="mb-0">{{ $data['active'] }}</h2>
                  
                </div>
              <small class="text-gray"> All Active Commodities</small>

              </div>

              <div class="d-inline-block">
                <div class="bg-success px-3 px-md-4 py-2 rounded">
                  <i class="mdi mdi-cart-outline text-white icon-lg"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     <div class="col-md-6 grid-margin">
      <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-0">Commodities</h6>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-inline-block pt-3">
                <div class="d-lg-flex">
                <h2 class="mb-0">{{ $data['count'] }}</h2>
                  <div class="d-flex align-items-center ml-lg-2">
                    
                   
                  </div>
                </div>
                <small class="text-gray">All Commodities</small>
              </div>
              <div class="d-inline-block">
                <div class="bg-warning px-3 px-md-4 py-2 rounded">
                  <i class="mdi mdi-cart-outline text-white icon-lg"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  @if( auth('admin')->user()->can('add commodity') )
  <div class="row">
      <div class="col-md-3 pull-right">
      <a class="btn btn-sm btn-primary " href="{{ route('admin.productmgt.store.view') }}"><i class="mdi mdi-plus-circle-outline"></i> Add new commodity</a>
  
      </div>
  </div>

  <br>
  @endif
 <div class="row"> 
    <div class="col-12">
      <div class="row portfolio-grid">
        @forelse ($data['products'] as $product)
    
          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
            <a href="{{ route('admin.productmgt.show',['product' => $product->id]) }}">
            <figure class="effect-text-in">
            <img src="{{ asset('storage/'.$product->product_image) }}" width="150px" height="150px" alt="image"/>
              <figcaption>
                <h4>{{ $product->commodity_name }}</h4>
              <p>{{ substr($product->description,0,50) }}</p>
              </figcaption>			
            </figure>
        </a>
           
          </div>
        @empty
        <div class="col-md-12">
            <p class="text-center">No product added</p>

        </div>
        @endforelse
      
     
      </div>
      <div style="float: right">
        {!!  $data['products']->links('dashboard.pagination')  !!}

        </div>
    </div>
  </div>
  
  

@endsection