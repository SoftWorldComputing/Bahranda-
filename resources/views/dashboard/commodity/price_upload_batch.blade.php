@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')
<div class="row">
     
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                 <h4 class="card-title">Search</h4>
               <form action="?">
                 <div class="form-group row">
                   <div class="col-md-10">
                   <input type="text" value="{{ app()->request->keyword  }}" name="keyword" id="" placeholder="Search partnership" class="form-control">
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
          <h4 class="card-title">Price Upload Batches</h4>
          <p class="card-description">
            Table of all price uploads
          </p>
          <div class="d-flex table-responsive">
          
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th> Batch No</th>
                  <th>No of prices uploaded</th>
                  <th>Status</th>
                  <th>Date Uploaded</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @forelse ($batches as $batch)
                  <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $batch->batch_no }}</td>
                  <td>{{ $batch->no_of_data }}</td>
                   
                    <td>
                        @if ($batch->status == 0)
                          <label class="badge badge-primary">Pending</label>

                        @elseif($batch->status == 1)
                          <label class="badge badge-success">Authorized and Uploaded</label>

                        @elseif($batch->status == 2)
                          <label class="badge badge-danger">Upload Declined</label>
                        @endif

                    </td>
                  <td>{{ $batch->created_at->diffForHumans() }}</td>
                    <td>
                    <a href="{{ route('admin.commodity_price.price_upload.batch.data',['batch_no' => $batch->batch_no])}}" class="btn btn-primary btn-sm">View</a>
                    @if($batch->status == 0 && auth('admin')->user()->can('authorize price upload'))
                    <form method="POST" id="authorize_price" style="display:inline" action="{{ route('admin.commodity_price.list.update.authorize',['batch_no' => $batch->batch_no])}}">
                        <input type="hidden" name="type" value="1">

                        <button type="submit" id="authorize_price-button" class="btn btn-success btn-sm">Authorize</button>

                    </form>
                    <form method="POST" id="decline_price" style="display:inline"  action="{{ route('admin.commodity_price.list.update.authorize',['batch_no' => $batch->batch_no])}}">
                        <input type="hidden" name="type" value="2">
                        <button type="submit" id="decline_price-button" class="btn btn-danger btn-sm">Declined</button>

                    </form>
                    @endif
                    </td>
                </tr>
               
                  @empty 
                        <tr>
                            <td colspan="6"> No price uploads yet</td>
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
@push('app_js')
<script src="/js/bahranda.js"></script>
<script src="/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>

@endpush

@push('app_css')
<link rel="stylesheet" href="/vendors/jquery-toast-plugin/jquery.toast.min.css">
@endpush