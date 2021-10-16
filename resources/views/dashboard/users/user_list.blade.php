@extends('dashboard.layout')
@section('content')
@include('dashboard.users.admin.user_mgt_breadcrumb')

	 <div class="row">
	  	<div class="col-md-6 grid-margin">
			<div class="card">
                <div class="card-body">
                  <h6 class="card-title mb-0">Users</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{  $data['total_user'] }}</h2>
                        
                      </div>
                    <small class="text-gray">All Users</small>

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
                  <h6 class="card-title mb-0">Active Users</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ $data['active_user'] }}</h2>
                        <div class="d-flex align-items-center ml-lg-2">
                          
                         
                        </div>
                      </div>
                      <small class="text-gray">No of active users</small>
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
                    <div class="col-md-10">
                    <input type="text" value="{{ app()->request->keyword }}" name="keyword" id="" placeholder="Search admin name , email etc" class="form-control">
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
          <h4 class="card-title">User Management</h4>
          <p class="card-description">
            Table of all system user
          </p>
          <div class="d-flex table-responsive">
            <div>
          
          </div>
          
          
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th> Name</th>
                  <th> Email</th>
                  <th> Date registered</th>
                  <th> Status</th>
                  
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                
                @forelse ($data['users'] as $user)
                    
                    <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ ucwords($user->name) }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->diffForHumans() }}</td>
                    <td style="text-align: center"><span class="badge badge-{{ $user->active == 1 ? 'success' : 'danger' }}"> </span></td>
                   
                        <td>
                        <a href="{{ route('admin.user_mgt.show',['user' => $user->id]) }}" class="btn btn-primary">view</a>
                        </td>
                    
                    </tr>

                @empty
                    <tr >
                        <td colspan="5" class="text-center"> No user found</td>
                           
                    </tr>
               @endforelse
              </tbody>
            </table>
            <div style="float: right">
              {!!  $data['users']->links('dashboard.pagination')  !!}
  
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection