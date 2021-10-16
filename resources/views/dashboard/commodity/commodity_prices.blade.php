@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')

<div class="row">
     
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                 <h4 class="card-title">Search</h4>
               <form action="">
                 <div class="form-group row">
                   <div class="col-md-10">
                   <input type="text" value="{{ app()->request->keyword }}" name="keyword" id="" placeholder="Search commodity etc" class="form-control">
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
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Commodity Prices</h4>
        <div class="row">
            <div class="col-md-4">
                <p class="card-description">
                    List of all commodities and there prices</code>
                  </p>
            </div>

            <div class="col-md-8">
                <a class="btn btn-sm btn-primary " style="float:right" href="{{ route('admin.commodity_price.list.update.view') }}"> Update commodity prices</a>
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
                  Commodity Sell Price
                </th>
                <th>
                Last Updated
                </th>
               
              </tr>
            </thead>
            <tbody>
            @forelse($data['products'] as $commodity)
              <tr>
                <td class="py-1">
                <img src="{{ asset('storage/'.$commodity->product_image) }}" alt="image">
                </td>
                <td>
                 {{ $commodity->commodity_name}}
                </td>
                <td>
                    ₦{{ number_format($commodity->buy_price)}}<i class="mdi mdi-arrow-up text-green"></i>
                 </td>
                 <td>
                    ₦{{ number_format($commodity->sell_price)}} <i class="mdi mdi-arrow-down"></i>
                 </td>
                 <td>
                    {{ $commodity->updated_at->diffForHumans()}}
                 </td>
               
              </tr>
           @empty
               
           @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  

@endsection