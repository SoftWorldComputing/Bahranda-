@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')
<div class="card">
    <div class="row">
        <div class="col-md-4">
          <div class="card-body avatar">
              <h4 class="card-title">Commodity Image</h4>
              <img src="{{  asset('storage/'.$product->product_image)}}" width="200px" height="150px" alt="">
          </div>
          <div style="text-align : center">
            <p><a href="{{ route('admin.productmgt.edit.view',['product' => $product->id]) }}">Edit commodity</a></p>
            <p><a href="javascript:void(0)" onclick="ondelete( {{ '"'.route('admin.productmgt.delete',['commodity' => $product->id]).'"'}},'commodity')" >Delete commodity</a></p>
            <p><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal-2">Add new batch</a></p>
            <p><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal-3">Change batch</a></p>
            <p><a href=" {{route('admin.commodity.batch_history',['batch' => $product->currentBatch->batch_no,'commodity' => $product->id]) }}" >Batch history</a></p>
           <p><a href=" {{route('admin.commodity_price.purchase_for_user',['commodity' => $product->id]) }}" >Purchase For User</a></p>
         
          </div>
          
        </div>
  
        <div class="col-md-8" style="padding-top:40px">
            <h3>Cost breakdown</h3>
          <p>Commodity Name : {{ $product->commodity_name }}</p>
          <p>Purchase  price : ₦{{ number_format($product->buy_price) }}</p>
          <p>Total Purchase  price : ₦{{ number_format($product->purchase_price) }}</p>
          <p>Target Sell  price : ₦{{ number_format($product->sell_price) }}</p>
          <p>Profit Percentage : {{ $product->profit_margin}}%</p>
          <p>Warehouing : ₦{{ number_format($product->warehousing) }}</p>
          <p>Transportation : ₦{{ number_format($product->transportation) }}</p>
          <p>State Tax : {{ ($product->state_tax)}}% </p>
          <p>Duration : {{ intval($product->duration)}} Month(s) </p>
          <p>Description : {{ $product->description }}</p>
          <p>Availability : {{ $product->availability == 1 ? "available" : "unavailable"}}</p>
          <p>Current Batch : {{ $product->currentBatch->batch_no }}</p>
          <p>Current Batch Quantity : {{ $product->currentBatch->in_stock}}</p>
          <p>Minimum Quantity Purchasable : {{ $product->minimum_quantity}}</p>
        </div>
    </div>
</div>
 <br>
 <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Statistics</h4>
          <p class="card-description">
          
          </p>

          <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 grid-margin">
                    <div class="card">
                        <div class="card-body">
                        <h6 class="card-title mb-0">Sold</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-inline-block pt-3">
                            <div class="d-lg-flex">
                                <h2 class="mb-0">₦0</h2>
                                <div class="d-flex align-items-center ml-lg-2">
                                <i class="mdi mdi-clock text-muted"></i>
                                <small class="ml-1 mb-0">Updated: 9:10am</small>
                                </div>
                            </div>
                            </div>
                            <div class="d-inline-block">
                            <div class="bg-success px-3 px-md-4 py-2 rounded">
                                <i class="mdi mdi-arrow-down-bold  text-white icon-lg"></i>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                <div class="col-md-6 grid-margin">
                    <div class="card">
                    <div class="card-body">
                    <h6 class="card-title mb-0">Bought</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                        <div class="d-lg-flex">
                            <h2 class="mb-0">₦0</h2>
                            <div class="d-flex align-items-center ml-lg-2">
                            <i class="mdi mdi-clock text-muted"></i>
                            <small class="ml-1 mb-0">Updated: 05:42pm</small>
                            </div>
                        </div>
                     
                        </div>
                        <div class="d-inline-block">
                        <div class="bg-warning px-3 px-md-4 py-2 rounded">
                            <i class="mdi mdi-arrow-up-bold text-white icon-lg"></i>
                        </div>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row">
                {{-- <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Line chart</h4>
                      <canvas id="lineChart" style="height:250px"></canvas>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
<br>

  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Commodity Transactions</h4>
          <p class="card-description">
           Commodity transactions
          </p>
        
          
          
          </div>
       <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Sn</th>
                      <th> Transacion type</th>
                      <th> Amount</th>
                      <th>Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>  
                     <tr>
                         <td colspan="3">No transaction yet</td>
                     </tr>
                  </tbody>
                </table>
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
            <h4 class="card-title"> Batches</h4>
            <p class="card-description">
            All batches
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
                        <th> In Stock</th>
                        <th>Last Update</th>
                        <th>Current</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>  
                      

                      @forelse ($batches as $batch)
                       <tr>
                        <td>{{ $loop->iteration  }}</td>
                        <td>{{ $batch->batch_no }}</td>
                        <td>{{ $batch->in_stock }}</td>
                        <td>{{ $batch->updated_at->diffForHumans() }}</td>
                        <td>{{ $batch->is_current == 1 ? "YES" : "NO" }}</td>
                        <td>
                        <a class="btn btn-light" href="{{route('admin.commodity.batch_history',['batch' => $batch->batch_no,'commodity' => $product->id]) }}">
                            <i class="mdi mdi-eye text-primary"></i>View history
                           </a>
                        </td>
                       </tr>
                      @empty
                        <tr>
                          <td colspan="4"> No batch yet</td>
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


    {{--  --}}
  
 
@push('app_js')
<script src="/vendors/chart.js/Chart.min.js"></script>
<script src="/js/chart.js"></script>
<script src="/js/modal-demo.js"></script>
<script src="/js/bahranda.js"></script>

@endpush


@endsection

<div class="modal fade" id="exampleModal-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-2">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="new-batch-feedback"></span>

      <div class="modal-body">
        <h4>Add new batch</h4>
      <form action="{{ route('admin.commodity.add_new_batch',['commodity' => $product->id]) }}" id="add-new-batch" method="POST">
          <div class="form-group">
            <label for="name">Quantity </label>
            <input type="text" name="quantity"  id="" class="form-control">
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

<div class="modal fade" id="exampleModal-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-3">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="change-batch-feedback"></span>

      <form method="POST" id="change-batch"  action="{{ route('admin.commodity.change_batch',['commodity' => $product->id]) }}">

      <div class="modal-body">
        <p>Change Batch</p>
             <div class="form-group">
            
                 <select name="batch_no"  class="form-control" id="">
                   <option value="">Change Batch</option>
                      @foreach ($batches as $batch)
                         <option value="{{ $batch->batch_no }}">{{ $batch->batch_no }}</option>
                      @endforeach
                 </select>
             </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="change-batch-button" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
      </div>
    </form>

    </div>
  </div>
</div>
