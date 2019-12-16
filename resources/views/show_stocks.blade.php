@extends('layout.template')
@section('content')
<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Stocks</h2>
{{-- <div class="row" align="center" style="padding:30px; padding-bottom:0; margin-left:2px;margin-right:2px; border-radius:5px">
    <div class="col-md-3" style="height:150px;">
        <div style="background-color:purple; height:100%; width:90%; border-radius:20px">
            <div>
                <h3 style="color:white; display:inline-block">Total Stocks</h3>
                <div style="color:white; font-size:25px">{{count($stocks)}}</div>
            </div>
            <hr style="margin-top:0">
            <span>
                <a href="{{ route('showstocks')}}" style="color:white"> View Details >> </a>
            </span>
        </div>
    </div>
    <div class="col-md-3" style="height:150px;">
        <div style="background-color:skyblue; height:100%; width:90%; border-radius:20px">
            <div>
                <h3 style="color:white; display:inline-block">Total Sales</h3>
                <div style="color:white; font-size:25px">{{$sales}}</div>
            </div>
            <hr style="margin-top:0">
            <span>
                <a href="{{route('dailysalesreport')}}" style="color:white"> View Details >> </a>
            </span>
        </div>
    </div>
    <div class="col-md-3" style="height:150px;">
        <div style="background-color:limegreen; height:100%; width:90%; border-radius:20px">
            <div>
                <h3 style="color:white; display:inline-block">Expired Medicines</h3>
                <div style="color:white; font-size:25px">{{$expires}}</div>
            </div>
            <hr style="margin-top:0">
            <span>
                <a href="{{route('expiredmeds')}}" style="color:white"> View Details >> </a>
            </span>
        </div>
    </div>
    <div class="col-md-3" style="height:150px;">
        <div style="background-color:magenta; height:100%; width:90%; border-radius:20px">
            <div>
                <h3 style="color:white; display:inline-block">Expired Medicines</h3>
                <div style="color:white; font-size:25px">{{$expires}}</div>
            </div>
            <hr style="margin-top:0">
            <span>
                <a href="{{route('expiredmeds')}}" style="color:white"> View Details >> </a>
            </span>
        </div>
    </div>
</div> --}}
<a href="{{route('printstocks')}}" class="btn btn-primary btn-sm">
    <span class="glyphicon glyphicon-print"></span> Print Stocks
</a>
<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> All Medicine Stocks
                
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="stockstable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:70px">Serial No</th>
                                        {{-- <th style="width:100px">Invoice No</th> --}}
                                        <th>Medicine Name</th>
                                        <th>Company Name</th>
                                        <th style="width:100px">Category</th>
                                        <th style="width:100px">Quantity</th>
                                        {{-- <th style="width:100px">Expiry Date</th> --}}
                                        <th style="width:100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody  style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        {{-- <td>{{$stock->invoice_no}}</td> --}}
                                        <td>{{$stock->med_name}}</td>
                                        <td>{{$stock->company_name}}</td>
                                        <td>{{$stock->cat_name}}</td>
                                        <td>{{$stock->total_quantity}}</td>
                                        {{-- <td>{{$stock->expiry}}</td> --}}
                                        {{-- <td>
                                            @foreach ($expiry as $item)
                                                @if ($stock->fk_med_id == $item->fk_med_id)
                                                    {{date('d-m-Y' , strtotime($item->expiry))}}
                                                @endif
                                            @endforeach
                                        </td> --}}
                                    
                                        <td>
                                            <div class="btn-group">
                                                <button onClick='deleteStock({{$stock->stock_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
                                                {{-- <button class="btn btn-primary">B</button> --}}
                                                {{-- <button class="btn btn-primary">C</button> --}}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            {{-- <span>{{ $allcasesdata->links() }}</span> --}}
                    </div>    
                </div>
            </div>
                <!-- /.panel-body -->
        </div>
    </div>
</div>
    <!-- Stocks Modal -->
<div class="modal fade" id="deleteStockModal" tabindex="-1" role="dialog" aria-hidden="true"
data-backdrop="static">
   <div class="modal-dialog " role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="staticModalLabel">Confirmation</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <p>
                   Do you really want to delete this stock.
               </p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <form method="POST" action="{{ route('deletestock')}}">
                @csrf
                <input hidden type="text" id="idtodel" name="stock_id">
                <input class="btn btn-primary" type="submit" id="submit" value="Confirm">
                </form>
               {{-- <a class="btn btn-primary" href="{{route('deletecase' , Crypt::encrypt($case->case_id))}}">Confirm</a> --}}
           </div>
       </div>
   </div>
</div>
<!-- Stocks Modal -->
@endsection