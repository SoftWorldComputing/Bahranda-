@extends('dashboard.layout')
@section('content')
@include('dashboard.settings.rolemgt.role_breadcrumb')

	<div class="row">
	  	<div class="col-md-6 grid-margin">
	 	 	<div class="card">
                 <div class="card-body">
                  <h6 class="card-title mb-0">Roles</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ $roles->count() }}</h2>
                        
                      </div>
                    <small class="text-gray"> All admin roles</small>

                    </div>

                    <div class="d-inline-block">
                      <div class="bg-success px-3 px-md-4 py-2 rounded">
                        <i class="mdi mdi-buffer text-white icon-lg"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			</div>
		<div class="col-md-6 grid-margin">
			<div class="card">
                <div class="card-body">
                  <h6 class="card-title mb-0">Permissions</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ $permissions->count() }}</h2>
                        <div class="d-flex align-items-center ml-lg-2">
                          
                         
                        </div>
                      </div>
                      <small class="text-gray">All Permissions</small>
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
          <h4 class="card-title">Role Management</h4>
          <p class="card-description">
            Table of all system roles
          </p>
          <div class="d-flex table-responsive">
            <div>
            <a class="btn btn-sm btn-primary " href="{{ route('admin.rolemgt.create-role.view') }}"><i class="mdi mdi-plus-circle-outline"></i> Add new role</a>
            </div>
          
          
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th>Role Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($roles as $role)
                <tr>
                   <td>{{ $loop->iteration}}.</td>
                   <td> <label for="" class="badge badge-success">{{ ucwords($role->display_name) }}</label> </td>
                   <td>{{ $role->description }}</td>
                   <td>
                   <a class="btn btn-light" href="{{ route('admin.rolemgt.view',['role' => $role->name])}}">
                      <i class="mdi mdi-eye text-primary"></i>View
                    </a>
                   
            
                  </td>
                </tr>
                @empty
                <tr>
                   <td colspan="3">No role created yet</td>
                 
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection