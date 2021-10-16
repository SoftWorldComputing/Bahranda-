@extends('dashboard.layout')
@section('content')
@include('dashboard.warehouses.warehouse_breadcrumb')

{{-- checkout from warehouse --}}
<p>Checkout from warehouse</p>
<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            @include('flash::message')

            <fieldset class="form-group">
                <legend><span>Warehouse Items</span></legend>
            
                <div id="fullDiv">
                    <form action="{{ route('admin.warehousemgt.checkout.requests.submit',['warehouse' => $warehouse->id]) }}" method="POST">
                        @csrf
                    @forelse ($warehouse->commodities as $commodity)
            
                    <div class="form-group row" >
                        
                        <div class="form-group col-md-4" id="first"  >
                            <label for="address">Commodity</label>
                              <select name="commodities[]" id="" class="form-control">
                                
                                     <option value="{{ $commodity->id }}"> {{ $commodity->commodity_name}}</option>
                               
                              </select>
                        </div>
                        <div class="form-group col-md-4 text-center">
                            <label for="">Quantity in warehouse(bags)</label>
                            <br>

                           <label class="badge badge-danger badge-lg">{{ $commodity->pivot->quantity_in_store }}</label>     
                        </div>
            
                        <div class="form-group col-md-4">
                            <label for="address">Quantity to checkout</label>
                            <input type="number" name="quantity_to_checkout[]" value="0" class="form-control" id="exampleInputEmail1" placeholder="Enter quantity in warehouse">
                             
                        </div>
                       
                
                    </div>
                    @empty
                        <div class="row">
                            <p>No commodity in this warehouse</p>
                        </div>
                    @endforelse
                    @if(!$warehouse->commodities->isEmpty())
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-success" style="width:100%">Submit checkout</button>
                    
                        </div>
                    
                    </div>
                    @endif
                   </form>

                </div>
                    
              </fieldset>
          </div>
        </div>
    </div>
</div>

@endsection