@extends('dashboard.layout')
@section('content')
@include('dashboard.users.admin.user_mgt_breadcrumb')
<div class="row">
  <div class="col-md-4">
    <div class="card">
        <div class="card-body avatar" style="text-align: center">
          <h4 class="card-title">Image</h4>
        <img src="{{ $user->profile ? asset('storage/'.$user->profile->image) : asset('images/avatar.png') }}" width="150px" alt="">
      
        </div>
      </div>
  </div>   
   <div class="col-md-8">
      <div class="card">
          <div class="card-body">
            @include('flash::message')
             <h4>This basic information</h4>
             <p>Name : {{ $user->name }}</p>
             <p>Email : {{ $user->email }}</p>
                <p>Phone : {{ $user->phone }}</p>
                <p>Gender :  {{ ucwords($user->sex) }}</p>
                <p>Status :  {{ $user->active == 1?'Active' : 'Suspended' }}</p>
                <p> @if($user->active == 1) <a href="?user_status=suspend"  class="btn btn-danger">Suspend user</a>@else  <a href="?user_status=activate"  class="btn btn-primary">Activate user</a> @endif</p>
          </div>
        </div>
   </div>   
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Wallet information</h4>
                <br>
        <div class="row">
          <div class="col-md-6 grid-margin">
          <div class="card">
            <div class="card-body">
             
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-inline-block pt-3">
                  <div class="d-lg-flex">
                  <h2 class="mb-0">₦{{ number_format($user->wallet->balance) }}</h2>
                    <div class="d-flex align-items-center ml-lg-2">
                      <i class="mdi mdi-clock text-muted"></i>
                      <small class="ml-1 mb-0">Updated: {{ $user->wallet->updated_at->diffForHumans() }}</small>
                    </div>
                  </div>
                  <small >User Wallet Balance</small>
                  <br>
                  <div>
                     <a href="javascript:void(0)" data-toggle="modal" data-target="#funduser" class="btn btn-success"> Fund user</a>
                  </div>
                </div>
              
              </div>
            </div>
          </div>
           </div>
        <div class="col-md-6 grid-margin">
         <div class="card">
          <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-inline-block pt-3">
                  <div class="d-lg-flex">
                    <h2 class="mb-0">₦{{ number_format($user->wallet->withdrawn) }}</h2>
                    <div class="d-flex align-items-center ml-lg-2">
                      <i class="mdi mdi-clock text-muted"></i>
                      <small class="ml-1 mb-0">Updated: {{ $user->wallet->updated_at->diffForHumans() }}</small>
                    
                    </div>
                  </div>
                  <small>Withdrawals</small>
                </div>
               
              </div>
            </div>
          </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Wallet histories</h4>
                @forelse($user->walletHistory()->orderBy('id','desc')->take(5)->get() as $history)
                <div class="preview-list">
                    <div class="preview-item border-bottom px-0">
                    
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject">
                                    <span class="float-right small">
                                    <span class="text-muted pr-3">{{ $history->created_at->diffForHumans() }}</span>
                                    </span>
                                </h6>
                            <p>{{ $history->remark }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
                @empty  
                        <p>No wallet history</p>
                @endforelse
                @if($user->walletHistory()->count()  > 5)<span style="margin:auto 0"><a href="">More</a></span>@endif
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4>Bank Information</h4>
              <p>Bank Name : {{ $user->accountInfo ?$user->accountInfo->bank_name : 'No Bank Name Entered' }}</p>
              <p>Bank Account Number : {{ $user->accountInfo ?$user->accountInfo->account_no : 'No Bank Account Entered' }}</p>
              <p>Bank Account Name : {{ $user->accountInfo ?$user->accountInfo->account_name : 'No Bank Account Name Entered' }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4>Activities</h4>
                @forelse($user->userActivities()->orderBy('id','desc')->take(5)->get() as $activity)

                <div class="preview-list">
                    <div class="preview-item border-bottom px-0">
                    
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject">
                                    <span class="float-right small">
                                        <span class="text-muted pr-3">{{ $activity->created_at->diffForHumans() }}</span>
                                        </span>
                                    </h6>
                                <p>{{ $activity->remark }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div> 
                @empty  
                <p>No activities by user

                </p>
               @endforelse
               @if($user->userActivities()->count()  > 5)<span style="margin:auto 0"><a href="">More</a></span>@endif

            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Deals</h4>
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
                        @forelse($deals->take(5) as $partnership)
                       <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ ucwords($partnership->user->name) }}</td>
                           <td>{{ ucwords($partnership->commodity->commodity_name) }}</td>
                           <td>{{ $partnership->duration }} Months</td>
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
            </div>
        </div>
    </div>
</div>
@push('app_js')
<script src="/vendors/chart.js/Chart.min.js"></script>
<script src="/js/chart.js"></script>
<script src="/js/modal-demo.js"></script>
<script src="/js/bahranda.js"></script>

@endpush
@endsection

<div class="modal fade" id="funduser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-2">Fund user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="fund-user-feedback"></span>

      <div class="modal-body">
        <h4>Add amount to fund</h4>
      <form action="{{ route('admin.user_mgt.fund_user',['user' => $user->id]) }}" id="fund-user-wallet" method="POST">
          <div class="form-group">
            <label for="name">Amount </label>
            <input type="number" name="amount"  id="" class="form-control">
          </div>
          <div class="form-group">
             <button type="submit" id="submit-new-batch" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>