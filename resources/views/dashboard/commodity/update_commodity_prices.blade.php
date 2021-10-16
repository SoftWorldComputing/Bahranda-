@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')
<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Update Community Price</h4>
            @include('flash::message')
          <p>Please download the format to upload commodity prices   <a  href="{{ route('admin.commodity_price.list.update.format') }}"> here</a></p>
          <form method="POST" action="{{ route('admin.commodity_price.list.update') }}" enctype="multipart/form-data">

                @csrf
               <div class="form-group">
                    <label for="">Upload prices</label>
                    <input type="file" name="commodity_prices" id="" class="form-control">

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