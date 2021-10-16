@extends('dashboard.layout')
@section('content')
@include('dashboard.warehouses.warehouse_breadcrumb')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Warehouse Checkout  Data</h4>
        <div class="row">
            <div class="col-md-4">
                <p class="card-description">
                    List of  warehouse checkout  and there prices in batch ({{ $batch_no}})</code>
                  </p>
            </div>
           
        </div>
       
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>
                  Commodity image
                </th>
                <th>
                    Commodity Name
                </th>
                <th>
                 Warehouse
                </th>
                <th>
                 Quantity to checkout
                </th>
                <th>
                   Amount left in store
                </th>
               
              </tr>
            </thead>
            <tbody>
                @forelse ($batch_data as $data)
                <tr>
                <td class="py-1">
                        <img src="{{ asset('storage/'.$data->commodity->product_image) }}" alt="image">
                </td>
                <td>{{ $data->commodity->commodity_name }}</td>
                <td>{{ $data->warehouse->warehouse_name }}</td>
                <td>{{  number_format($data->quantity_to_checkout)}}</td>
                <td>{{  number_format($data->amount_left_in_store)}}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4">
                                    No data
                        </td>
                    </tr>
                    
                @endforelse
              
              

               
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection