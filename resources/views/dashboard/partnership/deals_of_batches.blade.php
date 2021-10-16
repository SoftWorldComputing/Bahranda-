@extends('dashboard.layout')
@section('content')
@include('dashboard.partnership.partnership_breadcrumb')
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
        <form action="{{ route('admin.partnership.batchupdatedeals') }}" method="POST" id="update_batch">
          @if( auth('admin')->user()->can('change deal status'))

             <select name="status" class="form-control col-md-2" style="display:inline-block" id="status">
                <option   value="">Change Deal status</option>
                <option   value="1">On-going</option>
                <option  value="2">Cancelled</option>
                <option value="3">Completed</option>
                <option  value="4">Closed</option>
             </select>
            
             @endif

             @if( auth('admin')->user()->can('assign deal to warehouse'))

             <select name="warehouse" class="form-control col-md-2" style="display:inline-block" id="warehouse">
                <option   value="">Assign Deals to warehouse</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                @endforeach
             </select>
             @endif
             <br>
             <br>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th></th>
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
                 <td><input type="checkbox" name="deals[]" value="{{ $partnership->id }}" class="form-control" id=""></td>
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
        </form>
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