@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"> Batches</h4>
          <p class="card-description">
          {{ $batch_no }} Batch History
          </p>
          </div>
       <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th>Sn</th>
                        <th> Batch No</th>
                        <th> Action </th>
                        <th> Total </th>
                        <th> In Stock( )</th>
                        <th>Date</th>
                     
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>  
                      

                      @forelse ($batch_logs as $log)
                       <tr>
                        <td>{{ $loop->iteration  }}</td>
                        <td>{{ $log->batch_no }}</td>
                        <td>{{ $log->action_type == 1 ? 'Check in' : 'Checkout'}}</td>
                        <td>{{ $log->quantity }} </td>
                        <td>{{ $log->in_stock }} </td>
                        <td>{{ $log->created_at->diffForHumans() }}</td>
                        
                       </tr>
                      @empty
                        <tr>
                          <td colspan="5"> No batch yet</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
  

@endsection
