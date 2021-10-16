@extends('dashboard.layout')
@section('content')
@include('dashboard.warehouses.warehouse_breadcrumb')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card text-center">
            <div class="card-body">
            <img src="{{ asset('storage/'.$warehouse->warehouse_image)}}" alt="image" class="img-lg rounded-circle mb-2">
            <h4>{{ $warehouse->warehouse_name }}</h4>
                <p class="text-muted">{{ $warehouse->city }},{{ $warehouse->state}} state</p>
                <p class="mt-4 card-text">
                       {{ $warehouse->address}}
                </p>

                <span>
                  @if(auth('admin')->user()->can('edit warehouse'))
                    {{-- <a class="btn btn-primary btn-sm mt-3 mb-4" style="color:white">Edit Warehouse</a> --}}
                    @endif
                    @if(auth('admin')->user()->can('checkout warehouse'))
                <a class="btn btn-primary btn-sm mt-3 mb-4" href="{{ route('admin.warehousemgt.checkout.view',['warehouse' => $warehouse->id]) }}" style="color:white">Checkout from Warehouse</a>
                @endif
                </span>
              
               
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card text-left">
            <div class="card-body">
            <p>Contact Person : {{ $warehouse->contact_person }}</p>
            <p>Contact Person Number :   {{ $warehouse->contact_person_phone }}</p>
            <p>Number of commodities(in bags) :   {{ $warehouse->commodities->count() }}</p>
                   
            </div>
        </div>
    </div>
</div>

 <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Warehouse Commodities</h4>
              <p class="card-description">
                Table of all commodities in warehouse
              </p>
              <div class="d-flex table-responsive">
                <div>
                  
                </div>
              
              
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Sn</th>
                      <th> Commodity</th>
                      <th> Quantiy in store (bags)</th>
        
                    </tr>
                  </thead>
                  <tbody>
                    
                  
                        @foreach ($warehouse->commodities as $commodity)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                        <td>{{ $commodity->commodity_name }}</td>
                            <td>{{ $commodity->pivot->quantity_in_store }}</td>
                           
                    
                    </tr>
                        @endforeach
                       
    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
 </div>

 <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Warehouse Log</h4>
          <p class="card-description">
            
          </p>
          <div class="d-flex table-responsive">
            <div>
              
            </div>
          
          
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th> User</th>

                  <th> Activity</th>
        
                </tr>
              </thead>
              <tbody>
                
              
                    @foreach ($warehouse->activity as $activities)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                      <td>{{ $activities->admin_name}}</td>

                        <td>{{ $activities->admin_name. " ".$activities->activity}} </td>
                            
                      </tr>
                    @endforeach
                  
                   

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection