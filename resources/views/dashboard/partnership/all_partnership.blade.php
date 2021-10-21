@extends('dashboard.layout')
@section('content')
@include('dashboard.partnership.partnership_breadcrumb')
<div class="row">
     <div class="col-md-3 grid-margin">
       <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-0">Active Deals</h6>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-inline-block pt-3">
                <div class="d-lg-flex">
                <h2 class="mb-0">{{ $active_partnerships }}</h2>
                  
                </div>
              <small class="text-gray"></small>

              </div>

              <div class="d-inline-block">
                <div class="bg-primary px-3 px-md-4 py-2 rounded">
                  <i class="mdi mdi-coin text-white icon-md"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
      <div class="col-md-3 grid-margin">
       <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-0">Completed Deals</h6>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-inline-block pt-3">
                <div class="d-lg-flex">
                <h2 class="mb-0">{{ $completed_partnerships }}</h2>
                  <div class="d-flex align-items-center ml-lg-2">
                    
                   
                  </div>
                </div>
                <small class="text-gray"></small>
              </div>
              <div class="d-inline-block">
                <div class="bg-success px-3 px-md-4 py-2 rounded">
                  <i class="mdi mdi-wallet text-white icon-md"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
 
      <div class="col-md-3 grid-margin">
        <div class="card">
           <div class="card-body">
             <h6 class="card-title mb-0">Cancelled Deals</h6>
             <div class="d-flex justify-content-between align-items-center">
               <div class="d-inline-block pt-3">
                 <div class="d-lg-flex">
                 <h2 class="mb-0">{{ $cancelled_partnerships }}</h2>
                   <div class="d-flex align-items-center ml-lg-2">
                   </div>
                 </div>
                 <small class="text-gray"></small>
               </div>
               <div class="d-inline-block">
                 <div class="bg-danger px-3 px-md-4 py-2 rounded">
                   <i class="mdi mdi-close-circle text-white icon-md"></i>
                 </div>
               </div>
             </div>
           </div>
         </div>
      </div>
  
      <div class="col-md-3 grid-margin">
        <div class="card">
           <div class="card-body">
             <h6 class="card-title mb-0">Closed Deals</h6>
             <div class="d-flex justify-content-between align-items-center">
               <div class="d-inline-block pt-3">
                 <div class="d-lg-flex">
                 <h2 class="mb-0">{{ $closed_partnerships }}</h2>
                   <div class="d-flex align-items-center ml-lg-2">
                   </div>
                 </div>
                 <small class="text-gray"></small>
               </div>
               <div class="d-inline-block">
                 <div class="bg-warning px-3 px-md-4 py-2 rounded">
                   <i class="mdi mdi-window-closed text-white icon-md"></i>
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
                   <input type="text" value="" name="keyword" id="" placeholder="Search deals" class="form-control">
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
          <h4 class="card-title">Deals Management</h4>
          <p class="card-description">
            Table of all deals
          </p>
          <div class="d-flex table-responsive">
          
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th> Name</th>
                  <th> Commodity</th>
                  <th>Duration</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  @forelse($partnerships as $partnership)
                 <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td><a href="{{ route('admin.user_mgt.show',['user' => $partnership->user->id]) }}"> {{ ucwords($partnership->user->name) }}</a></td>
                     <td>{{ ucwords($partnership->commodity->commodity_name) }}</td>
                     <td>{{ intval($partnership->duration) }} Months</td>
                     <td>
                         @if($partnership->status == 1)
                           <label class="badge badge-primary">On-going</label>
                          @elseif($partnership->status == 2)
                           <label class="badge badge-danger">Cancelled</label>
                        @elseif($partnership->status == 3)
                           <label class="badge badge-success">Completed</label>
                        @elseif($partnership->status == 4)
                           <label class="badge badge-warning">Closed</label>
                        @endif
                     </td>
                     <td>
                     <a href="{{ route('admin.partnership.view_partnership',['partnership' => $partnership->id]) }}" class="btn btn-primary">view</a>
                     </td>
                 </tr>
                 @empty 
                    <tr>
                        <td colspan="6">No partnership available yet</td>
                    </tr>

                 @endforelse
              </tbody>
            </table>

            <div style="float: right">
            {!!  $partnerships->links('dashboard.pagination')  !!}

            </div>
          </div>
        </div>
      </div>
    </div>
 </div>


@endsection