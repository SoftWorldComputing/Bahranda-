@extends('dashboard.layout')
@section('content')

@can('view dashboard')

    <div class="row">
      <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-md-center">
              <i class="mdi mdi-basket icon-lg text-success"></i>
              <div class="ml-3">
                <p class="mb-0"> Daily deals</p>
              <h6>{{ $daily_deals_no }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-md-center">
              <i class="mdi mdi-shopping icon-lg text-warning"></i>
              <div class="ml-3">
                <p class="mb-0"> Monthly deals</p>
              <h6>{{ $monthly_deals_no  }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-md-center">
              <i class="mdi mdi-cash icon-lg text-info"></i>
              <div class="ml-3">
                <p class="mb-0">Monthly deals amount</p>
              <h6>₦{{ number_format($monthly_deals_amt) }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-md-center">
              <i class="mdi mdi-chart-line-stacked icon-lg text-danger"></i>
              <div class="ml-3">
                <p class="mb-0">Total profit</p>
              <h6>₦{{ number_format($total_revenue) }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   <div class="row">
     
   </div>
    <div class="row grid-margin">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Deals</h6>
           
            <div class="table-responsive">
              <table class="table mt-3 border-top">
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
                    @forelse($deals as $partnership)
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
            </div>
          
          </div>
        </div>
      </div>
    </div>
 
@endcan

@cannot('view dashboard')
    Other realated content
@endcannot
  

@endsection

@push('app_css')
<link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
<link rel="stylesheet" href="/vendors/simple-line-icons/css/simple-line-icons.css">
<link rel="stylesheet" href="/vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
@endpush

@push('app_js')
<script src="/vendors/chart.js/Chart.min.js"></script>
<script src="/vendors/raphael/raphael.min.js"></script>
<script src="/vendors/morris.js/morris.min.js"></script>
<script src="/vendors/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="/js/dashboard.js"></script>
@endpush