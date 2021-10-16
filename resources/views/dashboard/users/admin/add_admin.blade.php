@extends('dashboard.layout')
@section('content')
@include('dashboard.users.admin.admin_mgt_breadcrumb')
<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add New Admin</h4>
            <p class="card-description">
              Add new admin 
            </p>
            @include('flash::message')

           <form method="POST" action="{{ route('admin.admin_mgt.store') }}">

                @csrf
                <div class="form-group">
                    <label for="name">Email</label>
                  <input type="email" class="form-control" id="first_name" name="email" placeholder="Enter email ">
                  </div>
                <div class="form-group">
                  <label for="name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name">
                </div>
                <div class="form-group">
                  <label for="designation">Last Name</label>
                  <input type="text" class="form-control" name="last_name" id="designation" placeholder="Enter last name">
                </div>
                <div class="form-group">
                  <label for="mobile">Mobile Number</label>
                  <input type="text" class="form-control" id="mobile" name="phone"   placeholder="Enter mobile number">
                </div>
               
                <div class="form-group">
                  <label for="address">Sex</label>
                    <select name="sex" id="" class="form-control">
                        <option  value="1">Male</option>
                        <option  value="2">Female</option>
                    </select>
                </div>

                <div class="form-group">
                  <label for="address">Role</label>
                    <select name="role" id="" class="form-control">
                        @foreach ($roles as $role)
                          <option value="{{ $role->id }}" >{{ $role->display_name }}</option>
                        @endforeach
                       
                    </select>
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