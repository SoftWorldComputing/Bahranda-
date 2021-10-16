@extends('dashboard.layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Change Password</h4>
            <p class="card-description">
             
            </p>
            @include('flash::message')

            <form class="forms-sample" method="POST" action="{{ route('admin.settings.change_password',['admin' => auth('admin')->user()->id]) }}">
              <div class="form-group">
                <label for="exampleInputEmail1">Enter Old Password</label>
                <input type="password" name="old_password" class="form-control" id="exampleInputEmail1" placeholder="Enter old password">
                @csrf
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Enter New Password</label>
                    <input type="password" name="new_password" class="form-control" id="exampleInputEmail1" placeholder="Enter new password">

              </div>
            
              <div class="form-group">
                <label for="exampleInputEmail1">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="form-control" id="exampleInputEmail1" placeholder="Confirm new password ">
              
             </div>


              <button type="submit" class="btn btn-success mr-2">Submit</button>
              
            </form>
          </div>
        </div>
      </div>
</div>


@endsection