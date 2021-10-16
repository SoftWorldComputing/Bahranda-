@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')


<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Purchase Commodity For User</h4>
            <p class="card-description">
             Confirm Commodity Purchase 
            </p>
            @include('flash::message')

           <form method="POST" action="{{ route('admin.admin_mgt.store') }}">

                @csrf
               <div class="form-group">
                  <label for="name">User</label>
                    <input type="text" class="form-control" id="user_balance" name="user_balance" placeholder="user Name" value="Shola Bowale">
                </div>

                <div class="form-group">
                  <label for="name">User balance</label>
                    <input type="text" class="form-control" id="user_balance" name="user_balance" placeholder="user balance" value="20000">
                </div>

            
                <div class="form-group">
                  <label for="name">Quantity Of Commodity</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="50">
                </div>
            
                <div class="form-group mt-5">
                  <button type="submit" class="btn btn-success mr-2">Submit</button>
               
                </div>
              </form>
          </div>
        </div>
      </div>
</div>
  

@endsection