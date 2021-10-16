@extends('dashboard.layout')
@section('content')
@include('dashboard.users.admin.admin_mgt_breadcrumb')

	<div class="row">
	  	<div class="col-md-6 grid-margin">
			<div class="card">
                <div class="card-body">
                  <h6 class="card-title mb-0">Admin</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{  $data['count'] }}</h2>
                        
                      </div>
                    <small class="text-gray">All admin</small>

                    </div>

                    <div class="d-inline-block">
                      <div class="bg-success px-3 px-md-4 py-2 rounded">
                        <i class="mdi mdi-account-multiple text-white icon-lg"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			</div>
		<div class="col-md-6 grid-margin">
			<div class="card">
                <div class="card-body">
                  <h6 class="card-title mb-0">Roles</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ $data['roles_count'] }}</h2>
                        <div class="d-flex align-items-center ml-lg-2">
                          
                         
                        </div>
                      </div>
                      <small class="text-gray">No of roles</small>
                    </div>
                    <div class="d-inline-block">
                      <div class="bg-warning px-3 px-md-4 py-2 rounded">
                        <i class="mdi mdi-wallet text-white icon-lg"></i>
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
                <form action="">
                  <div class="form-group row">
                    <div class="col-md-7">
                    <input type="text" value="{{ app()->request->keyword }}" name="keyword" id="" placeholder="Search admin name , email etc" class="form-control">
                    </div>

                    <div class="col-md-3">
                         <select name="role" id="" class="form-control">
                             <option   value="">Filter role</option>
                             @foreach ($data['roles'] as $role)
                             <option value="{{ $role->id }}" @if(app()->request->role == $role->id) selected @endif> {{ $role->display_name }}</option>
                             @endforeach
                           
                             
                        </select>
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

        
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Admin Management</h4>
          <p class="card-description">
            Table of all system admin
          </p>
          <div class="d-flex table-responsive">
            <div>
              @if(auth('admin')->user()->can('create admin'))
            <a class="btn btn-sm btn-primary" href="{{ route('admin.admin_mgt.store.view') }}"><i class="mdi mdi-plus-circle-outline"></i> Add new admin</a>
            @endif
            </div>
          
          
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th> Name</th>
                  <th> Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                
                @forelse ($data['admins'] as $admin)
                    
                    <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ ucwords($admin->name) }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ ucwords(join(" ",explode("_",$admin->getRoleNames()[0]))) ?? "Not Available" }}</td>
                    <td>
                        @if($admin->hasRole('super_admin') )
                            @if(auth('admin')->user()->hasRole('super_admin'))
                            <a class="btn btn-light" href="{{ route('admin.adminmgt.show',['admin' => $admin->id])}}">
                            <i class="mdi mdi-eye text-primary"></i>View
                           </a>
                           @endif
                        @else
                          <a class="btn btn-light" href="{{ route('admin.adminmgt.show',['admin' => $admin->id])}}">
                            <i class="mdi mdi-eye text-primary"></i>View
                           </a>
                           <a class="btn btn-light" href="{{ route('admin.adminmgt.remove',['admin' => $admin->id])}}">
                            <i class="mdi mdi-delete text-danger"></i>Delete
                           </a>
                        @endif
                       
                    </td>
                    
                    </tr>

                @empty
                    <tr >
                        <td colspan="5" class="text-center"> No admin found</td>
                           
                    </tr>
               @endforelse
              </tbody>
            </table>
            <div style="float: right">
              {!!  $data['admins']->links('dashboard.pagination')  !!}
  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection