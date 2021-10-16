@extends('dashboard.layout')
@push('app_css')
<link rel="stylesheet" href="/vendors/dropify/dropify.min.css">
@endpush
@section('content')
@include('dashboard.users.admin.admin_mgt_breadcrumb')

<div class="row user-profile">
    <div class="col-lg-4 side-left d-flex align-items-stretch">
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body avatar">
              <h4 class="card-title">Info</h4>
            <img src="{{  asset('storage/'.$admin->image)}}" alt="">
            <p class="name">{{ $admin->name }}</p>
              <p class="designation">- {{ ucwords(join(" ",explode("_",$admin->getRoleNames()[0]))) ?? "Not Available"  }}  -</p>
            <a class="d-block text-center text-dark" href="#">{{ $admin->email }}</a>
            <a class="d-block text-center text-dark" href="#">{{ $admin->phone }}</a>
            </div>
          </div>
        </div>
        <div class="col-12 stretch-card">
          <div class="card">
            <div class="card-body overview">
                    <h1 class="text-center">S</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8 side-right stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0">Details</h4>
            <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-expanded="true">Info</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar">Avatar</a>
              </li>
             
            </ul>
          </div>
          <div class="wrapper">
            <hr>
            <div class="tab-content" id="myTabContent">

              <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                @include('flash::message')

                 <form method="POST" action="{{ route('admin.admin_mgt.update',['admin' => $admin->id]) }}">
                    @csrf
                  <div class="form-group">
                    <label for="name">First Name</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $admin->first_name }}" placeholder="Change first name">
                  </div>
                  <div class="form-group">
                    <label for="designation">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="designation" value="{{ $admin->last_name }}" placeholder="Change last name">
                  </div>
                  <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" class="form-control" id="mobile" name="phone"  value="{{ $admin->phone }}"  placeholder="Change mobile number">
                  </div>
                 
                  <div class="form-group">
                    <label for="address">Sex</label>
                      <select name="sex" id="" class="form-control">
                          <option @if($admin->sex == 1) selected @endif value="1">Male</option>
                          <option  @if($admin->sex == 2) selected @endif  value="2">Female</option>
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="address">Role</label>
                      <select name="role" id="" class="form-control">
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if($role->name == $admin->getRoleNames()[0]) selected @endif>{{ $role->display_name }}</option>
                          @endforeach
                         
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="address">Active</label>
                      <select name="status" id="" class="form-control">
                          <option @if($admin->active == 1) selected @endif value="1">Active</option>
                          <option  @if($admin->active == 2) selected @endif  value="2">Inactive</option>
                      </select>
                  </div>
                  @if((auth('admin')->user()->can('edit admin') && !($admin->hasRole('super_admin'))) || (auth('admin')->user()->hasRole('super_admin')) || ($admin->id == auth('admin')->user()->id))
                  <div class="form-group mt-5">
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                 
                  </div>
                  @endif
                </form>
              </div><!-- tab content ends -->
              <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
               @include('flash::message')

                <div class="wrapper mb-5 mt-4">
                  <span class="badge badge-warning text-white">Note : </span>
                  <p class="d-inline ml-3 text-muted">Image size is limited to not greater than 1MB .</p>
                </div>
              <form action="{{ route('admin.admin_mgt.profile_image.update',['admin' => $admin->id]) }}" method="POST" enctype="multipart/form-data">
                  <input type="file" name="profile_image" class="dropify" data-max-file-size="1mb" data-default-file="{{ asset(auth('admin')->user()->image) }}"/>
                  @csrf


                  <div class="form-group mt-5">
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                   
                  </div>
                </form>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  

@endsection

@push('app_js')
  <script src="/vendors/dropify/dropify.min.js"></script>
  <script src="/js/dropify.js"></script>
@endpush
