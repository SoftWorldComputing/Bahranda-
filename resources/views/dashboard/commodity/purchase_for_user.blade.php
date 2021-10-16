@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')


<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Purchase Commodity For User</h4>
            <p class="card-description">
              Purchase Commodity
            </p>
            @include('flash::message')

           <form method="POST" action="{{ route('admin.commodity_price.purchase_for_user.store',['commodity' => $commodity->id]) }}">

                @csrf
               <div class="form-group">
                  <label for="address">Select User</label>
                    <select name="user" id="user" class="form-control" required>
                         <option  value="">Select user</option>
                    @forelse ($users as $user)
                      <option  value="{{ $user->id}}">{{ $user->first_name}} {{ $user->last_name}}</option>
                     
                     @empty
                            
                     @endforelse
                       
                    </select>
                </div>
                 <div class="form-group">
                  <label for="name">User balance</label>
                    <input type="text" class="form-control" id="user_balance" name="user_balance" placeholder="user balance" value="0" readonly>
                </div>
                <div class="form-group row">
                <div class="form-group col-md-8">
                  <label for="name">Quantity Of Commodity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                    <span style="color:red" id="qty_error_message"></span>
                  </div>
                  
                  <input type="hidden" name="commodity_id" value="{{ $commodity->id }}" id="commodity_id">

                   <div class="form-group col-md-4">
                       <br>
                         <a class="btn btn-success" onclick="checkPrice(event)"  href="#">
                                check
                              </a>
                   </div>
                </div>
              
             <div class="" id="price_check" style="display: none;padding: 5px 10px ;background:#eee">
                   
              </div>
              

                <div class="form-group mt-5">
                  <button type="submit" class="btn btn-success mr-2">Purchase</button>
               
                </div>
              </form>



              
          </div>
        </div>
      </div>
</div>
  

@endsection
  @push('app_js')
        <script src="/js/purchase_for_user.js"></script>
 @endpush