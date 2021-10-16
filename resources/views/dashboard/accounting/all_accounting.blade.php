@extends('dashboard.layout')
@section('content')
@include('dashboard.accounting.accounting_breadcrumb')
<div class="row">
     <div class="col-md-6 grid-margin">
       <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-0">Total Closed Deals</h6>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-inline-block pt-3">
                <div class="d-lg-flex">
                <h2 class="mb-0">{{ $no_of_closed_deals }}</h2>
                  
                </div>
              <small class="text-gray"></small>

              </div>

              <div class="d-inline-block">
                <div class="bg-primary px-3 px-md-4 py-2 rounded">
                  <i class="mdi mdi-wallet text-white icon-md"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
      <div class="col-md-6 grid-margin">
       <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-0">Profit</h6>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-inline-block pt-3">
                <div class="d-lg-flex">
                <h2 class="mb-0">₦{{number_format ($profit_made) }}</h2>
                  <div class="d-flex align-items-center ml-lg-2">
                    
                   
                  </div>
                </div>
                <small class="text-gray"></small>
              </div>
              <div class="d-inline-block">
                <div class="bg-success px-3 px-md-4 py-2 rounded">
                  <i class="mdi  mdi-coin text-white icon-md"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
<div class="row">
     
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                 <h4 class="card-title">Search</h4>
               <form action="?">
                 <div class="form-group row">
                   <div class="col-md-12">
                   <input type="text" value="" name="keyword" id="" placeholder="Search deals" class="form-control">
                   </div>
                  
                 </div>
                 <div class="form-group row">
                    <div class="col-md-6">
                        <label for="">Date From</label>
                        <input type="date" name="date_from" id="" class="form-control">
                    </div>
                    <div class="col-md-6">
                     <label for="">Date To</label>
                     <input type="date" name="date_to" id="" class="form-control">
                    </div>
                 </div>
                 <div class="form-group row justify-content-center" style="text-align:center">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-outline-primary ">Search deals</button>
                        <button type="submit" class="btn btn-outline-success ">Export as excel</button>
                   </div>
                 </div>
               </form>
            </div>
       </div>
   </div>
  
</div>

 <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Closed deals</h4>
          <p class="card-description">
            
          </p>
          <div class="d-flex table-responsive">
          
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th> Commodity</th>
                  <th>Buy Price (per bag)</th>
                  <th>Quantity</th>
                  <th>Sold Price (per bag)</th>
                  <th>Amount invested</th>
                  <th>Real Market Sold(per bag)</th>
                  <th>Real Market total</th>
                  <th>Profit</th>
                 
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  @forelse ($accountings as $accounting)
                      <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ ucwords($accounting->commodity->commodity_name)}}</td>
                      <td>₦{{ number_format(floatval($accounting->partnership_br->buy_price))}}</td>
                      <td>{{ $accounting->quantity }} bags</td>
                      <td>₦{{ number_format(floatval($accounting->partnership_br->sell_price))}}</td>
                      <td>₦{{ number_format($accounting->amount)}}</td>
                      <td>₦{{ number_format($accounting->real_amount_sold)}}</td>
                      <td>₦{{ number_format($accounting->real_amount_sold * $accounting->quantity)}}</td>
                      <td>₦{{ number_format($accounting->profit)}}</td>
                      <td><a href="{{ route('admin.partnership.view_partnership',['partnership' => $accounting->id]) }}" class="btn btn-primary">view</a></td>
                      </tr>
                  @empty 

                      <tr>
                          <td colspan="8">
                              No closed deal yet
                          </td>
                      </tr>
                  @endforelse
                
              </tbody>
            </table>
            <div style="float: right">
              {!!  $accountings->links('dashboard.pagination')  !!}
  
              </div>
          </div>
        </div>
      </div>
    </div>
 </div>


@endsection