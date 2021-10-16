@extends('dashboard.layout')
@section('content')
@include('dashboard.partnership.partnership_breadcrumb')
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
                  <th> Batch</th>
                  <th> Number of deals</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                  @foreach($partnerships as $batch_no => $partnership)
                   <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $batch_no }}</td>
                     <td>{{ $partnership->count() }}</td>
                    
                     <td>
                     <a href="{{ route('admin.partnership.batch_deals',['batch_no' => $batch_no ]) }}" class="btn btn-primary">view</a>
                     </td>
                 </tr>
                
                @endforeach
              </tbody>
            </table>

           
          </div>
        </div>
      </div>
    </div>
 </div>

@endsection