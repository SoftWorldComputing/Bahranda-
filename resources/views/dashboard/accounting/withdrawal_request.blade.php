@extends('dashboard.layout')
@section('content')
@include('dashboard.accounting.accounting_breadcrumb')


	<div class="row">
	  	<div class="col-md-3 grid-margin">
	 	 	<div class="card">
                 <div class="card-body">
                  <h6 class="card-title mb-0">Pending request</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ $pending_count}}</h2>
                        
                      </div>
                    <small class="text-gray"> Number of pending request</small>

                    </div>

                    <div class="d-inline-block">
                      <div class="bg-success px-3 px-md-4 py-2 rounded">
                        {{-- <i class="mdi mdi-buffer text-white icon-lg"></i> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
		</div>
		 <div class="col-md-3 grid-margin">
			<div class="card">
                <div class="card-body">
                  <h6 class="card-title mb-0">Paid request</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ $paid_count}}</h2>
                        <div class="d-flex align-items-center ml-lg-2">
                          
                         
                        </div>
                      </div>
                      <small class="text-gray">All paid requests</small>
                    </div>
                    <div class="d-inline-block">
                      <div class="bg-warning px-3 px-md-4 py-2 rounded">
                        {{-- <i class="mdi mdi-wallet text-white icon-lg"></i> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        
          <div class="col-md-3 grid-margin">
			<div class="card">
                <div class="card-body">
                  <h6 class="card-title mb-0">Denied Request</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ $denied }}</h2>
                        <div class="d-flex align-items-center ml-lg-2">
                          
                         
                        </div>
                      </div>
                      <small class="text-gray">All paid requests</small>
                    </div>
                    <div class="d-inline-block">
                      <div class="bg-warning px-3 px-md-4 py-2 rounded">
                        {{-- <i class="mdi mdi-wallet text-white icon-lg"></i> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-3 grid-margin">
			<div class="card">
                <div class="card-body">
                  <h6 class="card-title mb-0">Total Paid</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-block pt-3">
                      <div class="d-lg-flex">
                      <h2 class="mb-0">{{ number_format($total_balance) }}</h2>
                        <div class="d-flex align-items-center ml-lg-2">
                          
                         
                        </div>
                      </div>
                      <small class="text-gray">Total paid</small>
                    </div>
                    <div class="d-inline-block">
                      <div class="bg-warning px-3 px-md-4 py-2 rounded">
                        {{-- <i class="mdi mdi-wallet text-white icon-lg"></i> --}}
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
          <h4 class="card-title">Withdrawal requests</h4>
          <p class="card-description">
            Table of all withdrawal requests
          </p>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th>User</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  @forelse ($all as $item)
                  <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td><a href="{{ route('admin.user_mgt.show',['user' => $item->user->id]) }}">{{ $item->user->name }}</a></td>
                  <td>{{ number_format($item->amount) }}</td>
                    <td> {{ ucwords($item->status) }} </td>
                    <td>
                        @if($item->status == "pending")
                        <a href="" class="btn btn-success" onclick="return changeWithdrawalStatus(event,'paid',this,{{ ''.$item->id }})">Paid</a>
                        <a href="" class="btn btn-danger" onclick="return changeWithdrawalStatus(event,'denied',this,{{ ''.$item->id }})">Denied</a>
                        @endif
                    </td>
                </tr>
                  @empty
                      <tr>
                          <td></td>
                          <td colspan="2">No withdrawal request yet from users</td>
                          <td></td>
                      </tr>
                  @endforelse
                 
                 
              </tbody>
            </table>
            <div style="float: right">
              {!!  $all->links('dashboard.pagination')  !!}
  
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@push('app_js')
<script src="/js/bahranda.js"></script>
<script src="/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
@endpush
@push('app_css')
<link rel="stylesheet" href="/vendors/jquery-toast-plugin/jquery.toast.min.css">
@endpush