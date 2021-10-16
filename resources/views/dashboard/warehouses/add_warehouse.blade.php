@extends('dashboard.layout')
@section('content')
@include('dashboard.warehouses.warehouse_breadcrumb')

<form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('admin.warehousemgt.add_warehouse') }}">

<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add New Warehouse</h4>
            <p class="card-description">
              Add new warehouse
            </p>
            @include('flash::message')

                @csrf

              <div class="form-group">
                <label for="exampleInputEmail1">Warehouse Name</label>
                <input type="text" name="warehouse_name" class="form-control" id="exampleInputEmail1" placeholder="Enter warehouse name">
              </div>

              <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <textarea name="address" id="" cols="10" rows="10" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Warehouse City</label>
                <input type="text" name="city" class="form-control" id="exampleInputEmail1" placeholder="Enter warehouse city">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Warehouse State</label>
                <input type="text" name="state" class="form-control" id="exampleInputEmail1" placeholder="Enter warehouse state">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Warehouse Contact Person</label>
                <input type="text" name="contact_person_name" class="form-control" id="exampleInputEmail1" placeholder="Enter person name">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Warehouse Contact Person Phone</label>
                <input type="text" name="contact_person_phone" class="form-control" id="exampleInputEmail1" placeholder="Enter Contact person phone">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Warehouse Image</label>
                    <input type="file" name="warehouse_image" id="" class="form-control">
              </div>
              
          </div>
        </div>
      </div>
</div>
<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <fieldset class="form-group">
                <legend><span>Warehouse Items</span></legend>
                 <p class="card-description">
                    add commodities into this warehouse
                </p>
                <div id="fullDiv">
                    <div class="form-group row" >
                        
                        <div class="form-group col-md-4" id="first"  >
                            <label for="address">Commodity</label>
                              <select name="commodities[]" id="" class="form-control">
                                  <option value="">Select commodity</option>
                                  @foreach ($commodities as $commodity)
                                     <option value="{{ $commodity->id }}"> {{ $commodity->commodity_name}}</option>
                                  @endforeach
                              </select>
                        </div>
            
                        <div class="form-group col-md-4">
                            <label for="address">Quantity in warehouse</label>
                            <input type="number" name="quantity_in_store[]" class="form-control" id="exampleInputEmail1" placeholder="Enter quantity in warehouse">
                             
                        </div>
                        <div class="form-group col-md-4">
                            <br>
                              <a class="btn btn-success" onclick="addOptions(event,this)"  href="#">
                                <i class="mdi mdi-plus-circle-outline"></i> 
                              </a>
                            
                        </div>
                
                    </div>
                </div>
                    
              </fieldset>
          </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4">
        <button type="submit" class="btn btn-outline-success" style="width:100%">Submit Warehouse</button>

    </div>

</div>

</form>

  

@endsection

@push('app_js')
    <script src="/js/warehouse.js"></script>
@endpush

{{-- 
     <div id="fullDiv">
                                <div class="row">
                                    <div class="col-8">
                                        <label class="form-control-label" for="input-name">Enter Options</label>
                                       <input type="text" name="options[]" id="input-name" class="form-control" placeholder="Answer" value="" >
                                    </div>
                                    <div class="col-3" id="current" style="padding-top:40px">
                                            <a href="#"   onclick="addOptions(event,this)" class="add_charges"><i class="fas fa-plus" ></i></a>
                                          
                                     </div>

                                    
                                </div>
                                
                            </div>

 --}}