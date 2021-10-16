@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Commodity Prices</h4>
        <div class="row">
            <div class="col-md-4">
                <p class="card-description">
                    List of all commodities  and there prices in batch ({{ $batch_no}})</code>
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
                 Commodity Buy Price
                </th>
                <th>
                  State tax
                 </th>
                <th>
                 Transportation
                </th>
                <th>
                  Warehousing
                 </th>
                 <th>
                  Other cost
                 </th>
                 <th>
                  Profit Percentage
                 </th>
                 <th>
                 Total purchase price
                 </th>

                 <th>
                  Calculated target sale price
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
                <td>₦{{  number_format($data->buy_price)}}</td>
                <td>{{  number_format($data->state_tax)}}%</td>
                 <td>₦{{  number_format($data->transportation)}}</td>
                 <td>₦{{  number_format($data->warehousing)}}</td>
                 <td>₦{{  number_format($data->other_costs)}}</td>
                 <td>{{  number_format($data->profit_margin)}} %</td>
                 <td>₦{{  number_format($data->total_purchase_price)}} </td>
                 <td>₦{{  number_format($data->target_sale_price)}} </td>
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