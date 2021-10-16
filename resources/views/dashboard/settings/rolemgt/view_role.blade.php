@extends('dashboard.layout')
@section('content')
@include('dashboard.settings.rolemgt.role_breadcrumb')
<div class="row justify-content-center">
    <div class="col-10 grid-margin ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add New Role</h4>
            <p class="card-description">
              Add new admin role
            </p>
            @include('flash::message')

        <form class="forms-sample" method="POST" action="{{ route('admin.rolemgt.update',['role' => $role->id]) }}">
              <div class="form-group">
                <label for="exampleInputEmail1">Role Name</label>
              <input type="text" value="{{ $role->display_name }}" name="display_name" class="form-control" id="exampleInputEmail1" placeholder="Enter role name">
                @csrf
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
              <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $role->description }}</textarea>
              </div>
              <fieldset class="form-group">
              <legend><span>Permissions</span></legend>
                    <div class="form-group category" >
                        @foreach($all_perms as $category => $permission)
                            <div class="row">
                              <label for="" class="col-md-3">{{ $category }}</label>
                              <div class="col-md-9" >
                                @foreach ($permission as $eachitem)
                                <div class="form-check form-check-flat" >
                                    <label class="form-check-label">
                                    <input type="checkbox" name="permissions[]" @if(in_array($eachitem->id,$permissions)) checked @endif value="{{ $eachitem->id }}" class="form-check-input">
                                        {{ $eachitem->description }}
                                    <i class="input-helper"></i>
                                    </label>
                                </div>
                                @endforeach
                             
                              </div>
                            </div>
                            <br>
                           
                        @endforeach
                    </div>
              </fieldset>


              <button type="submit" class="btn btn-success mr-2">Update</button>
             
            </form>
          </div>
        </div>
      </div>
</div>

@endsection
  