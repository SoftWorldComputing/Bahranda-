@extends('dashboard.layout')
@section('content')
@include('dashboard.partnership.partnership_breadcrumb')

    <div class="row">

        <div class="col-md-9 grid-margin">
            <div class="card">
               <div class="card-body">
                <h4>Commodities</h4>
                  <table class="table">
                      <thead>
                          <tr>
                              <th>Commodity name</th>
                              <th>Description</th>
                              <th>Quantity</th>
                          </tr>
                      </thead>
                      <tbody>

                        <tr>
                            <td>{{ ucwords($partnership->commodity->commodity_name) }}</td>
                            <td>{{ $partnership->commodity->description}} </td>
                            <td>{{ $partnership->quantity}} bags</td>
                        </tr>
                        <tr>
                            <td colspan="3">Total Quantity : {{ $partnership->quantity}} bags</td>
                            
                        </tr>
                      </tbody>
                   </table>
                
               </div>
             </div>
        </div>
       
       

          <div class="col-md-3 " style="height:260px !important">
            <div class="card" style="height : 100%">
               <div class="card-body">
                <h4>Deal status</h4>
                <form  id="change-partnership-status" method="POST" action="{{ route('admin.partnership.change-partnership-status',['partnership' => $partnership->id]) }}">
                  <div class="form-group">
                    <label for="">Deal status</label>
                    <select name="status" id="" @if($partnership->status == 4) disabled @endif class="form-control">
                         <option  @if($partnership->status == 1) selected @endif value="1">On-going</option>
                         <option @if($partnership->status == 2) selected @endif value="2">Cancelled</option>
                         <option @if($partnership->status == 3) selected @endif value="3">Completed</option>
                         <option @if($partnership->status == 4) selected @endif  value="4">Closed</option>
                    </select>
                </div>
                @if( auth('admin')->user()->can('change deal status') && $partnership->status < 4) 
                <div class="form-group">
                    <button type="submit" id="change-partnership-status-button" class="btn btn-success">Submit</button>
                </div>
               @endif
 
              </form>
              <p>
                @if($partnership->status == 3 &&  $partnership->real_amount_sold == 0)
                 <strong ><strong>Real sold price not specificied</strong></strong> 
                @endif

                @if($partnership->status == 3 && $partnership->real_amount_sold > 0)
            
              <span class="badge badge-danger"> <h4> Pay partner ₦{{ number_format(($partnership->expected_return) - ($partnership->amount))}} and closed deal</h4> </span>
                @endif


                @if($partnership->status == 4)
                <strong>Pay has been paid ₦{{ number_format(($partnership->partnership_br->sell_price * $partnership->quantity))}} and deal closed </strong>

                @endif
              </p>
            </div>
          </div>
       
          </div>
    </div>

    <div class="row">
        <div class="col-md-3 " style="height:260px !important">
            <div class="card" style="height : 100%">
               <div class="card-body">
                <h4>Warehouse</h4>
               <form id="assign-warehouse" method="POST" action="{{ route('admin.partnership.assignwarehouse',['partnership' => $partnership->id]) }}">
                  <div class="form-group">
                    <label for="">Select Warehouse</label>
                     <select name="warehouse" id="" class="form-control">
                         <option value=""> Select warehouse</option>
                         @foreach ($warehouses as $warehouse)
                             <option  @if($warehouse->id == $partnership->warehouse_id) selected  @endif value="{{ $warehouse->id }}">{{  $warehouse->warehouse_name}}</option>
                         @endforeach
                        
                    </select>
                </div>
               @if( auth('admin')->user()->can('assign deal to warehouse'))

                <div class="form-group">
                    <button type="submit" id="assign-warehouse-button" class="btn btn-success">Submit</button>
                </div>
                @endif
                  </form>


            </div>
          </div>
       
          </div>
         

          <div class="col-md-3 " style="height:260px !important">
            <div class="card" style="height : 100%;font-size : 20px">
               <div class="card-body">
                <h4>Deal User</h4>
               <p>  Name : <a href="{{ route('admin.user_mgt.show',['user' => $partnership->user->id]) }}">{{ $partnership->user->name }}</a></p>
               @if($partnership->user->profile_created == 1)
                <p>Phone : {{ $partnership->user->profile->phone }} </p>
                @endif
                <p>Account Number : {{ $partnership->user->accountInfo ? $partnership->user->accountInfo->account_no: "No Account Number" }} </p>
                <p>Account Name : {{ $partnership->user->accountInfo ? $partnership->user->accountInfo->account_name: "No Account Name" }} </p>
                <p>Account Bank : {{ $partnership->user->accountInfo ? $partnership->user->accountInfo->bank_name: "No Bank Name"}} </p>
            </div>
          </div>
       
          </div>

          <div class="col-md-3 " style="height:260px !important">
            <div class="card" style="height : 100%">
               <div class="card-body">
                <h4>Deal details</h4>
                 <p> {{ ucwords($partnership->commodity->commodity_name) }}: {{ $partnership->quantity }} bags</p>
                 <p>Duration :{{ $partnership->duration }} months</p>
               <p>Buys : ₦{{ number_format($partnership->partnership_br->buy_price) }}</p>
                 <p>Sell : ₦{{ number_format($partnership->partnership_br->sell_price) }}</p>
                
            </div>
          </div>
       
          </div>

         
          <div class="col-md-3 " style="height:260px !important">
            <div class="card" style="height : 100%">
               <div class="card-body">
                 
                <h4>Time Left</h4>
                @if($partnership->status == 1)
                   <span class="badge badge-primary" id="time-left"></span>
                @elseif($partnership->status == 2) 

                <span class="badge badge-danger" >Deal cancelled</span>

                @elseif($partnership->status == 3) 

                <span class="badge badge-success" >Deal Completed</span>
                @elseif($partnership->status == 4) 

                <span class="badge badge-success" > Deal Closed</span>
                @endif
            </div>
          </div>
 
       
          </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-6" >
        <div class="card" style="height : 100%;font-size : 15px">
          <div class="card-body" id="profit_analysis">
            <h4>Partner Gain Analysis</h4>
              <p>Commodity Price (p/b) :  ₦{{ number_format($partnership->partnership_br->buy_price)}}</p>
              <p>Commodity Purchase price (p/b):  ₦{{ number_format($partnership->partnership_br->purchase_price)}}</p>
              <p>Commodity Sale price (p/b) : ₦{{ number_format($partnership->partnership_br->sell_price) }}</p>
              <p>Commodity Profit Percentage (p/b) : {{ ($partnership->partnership_br->profit_margin) }}%</p>
              <p>Amount Invested : ₦{{ number_format($partnership->amount) }}</p>
              <p>Quantity : {{ $partnership->quantity }} bags </p>
              <p>Expected Return : ₦{{ number_format($partnership->expected_return)}} </p>
              <p>Profit : ₦{{ number_format(($partnership->expected_return - $partnership->amount ))}} </p>
           
        </div>
       </div>
    
      </div>
    
      <div class="col-md-6 " >
        <div class="card" style="height : 100%;font-size : 15px">
          <div class="card-body" id="profit_analysis">
            <h4>Bahranda Gain Analysis</h4>
             <p>Real Amount Commodity sold (p/b) :  ₦{{ number_format($partnership->real_amount_sold)}}</p>
             <p>Quantity  : {{ ($partnership->quantity) }} bags</p>
             <p>Total Amount Commodity sold (p/b) :  ₦{{ number_format($partnership->real_amount_sold * $partnership->quantity)}}</p>

          <p>Profit : @if($partnership->real_amount_sold  > 0) ₦{{ number_format( ($partnership->real_amount_sold * $partnership->quantity)  - ($partnership->partnership_br->sell_price *  $partnership->quantity))}} @else Commodity Not Sold Yet @endif</p>

          


          <p>After Deal Profit : @if($partnership->real_amount_sold  > 0) ₦{{ number_format( ($partnership->real_amount_sold * $partnership->quantity)  - $partnership->expected_return )}} @if(($partnership->real_amount_sold * $partnership->quantity - $partnership->expected_return) > 0) <span class="badge badge-success">Gain </span> @else <span class="badge badge-danger">Loss</span> @endif  @else Commodity Not Sold Yet @endif</p>
           
        </div>
       </div>
    
      </div>
    </div>
    <br>

  
  <div class="row">
    <div class="col-md-3 " style="height:260px !important">
      <div class="card" style="height : 100%;font-size : 20px">
        <div class="card-body">
          <h4>Price Breakdown</h4>
        <p>State tax : {{ $partnership->partnership_br->state_tax }}%</p>
        <p>Warehousing : ₦{{ number_format($partnership->partnership_br->warehousing) }}</p>
            <p>Transportation :  ₦{{ number_format($partnership->partnership_br->transportation) }}</p>
            <p>Other cost :  ₦{{ number_format($partnership->partnership_br->other_costs) }}</p>
      </div>
     </div>

    </div>
    @if( auth('admin')->user()->can('update real return') && $partnership->status > 2)
    <div class="col-md-3 " style="height:260px !important">
      <div class="card" style="height : 100%;font-size : 20px">
        <div class="card-body">
          <h4>Real Commodity sold(per bag)</h4>
        <form id="real_return_sold" action="{{ route('admin.partnership.real_price_sold',['partnership' => $partnership->id]) }}" method="POST"> 
             <div class="form-group row">
             <input type="number" name="real_amount" placeholder="Enter return sold" id="" value="{{ $partnership->real_amount_sold }}" class="form-control">
             </div>
             @if($partnership->real_amount_sold == 0)
            <div class="form-group">
              <button type="submit" id="real-return-sold-button" class="btn btn-success">Submit</button>
             </div>
             @endif
          </form>
      </div>
     </div>

    </div>

  
    @endif
  </div>





@endsection

@push('app_js')
<script src="/js/bahranda.js"></script>
<script src="/js/countdown.js"></script>
<script type="text/javascript" >
    $('#time-left').countdown(@php echo "'". $partnership->time_left ."'" @endphp , function(event) {
       $(this).html(event.strftime('%w weeks %d days %H:%M:%S'));
     });
</script>
<script src="/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>

@endpush

@push('app_css')
<link rel="stylesheet" href="/vendors/jquery-toast-plugin/jquery.toast.min.css">
@endpush