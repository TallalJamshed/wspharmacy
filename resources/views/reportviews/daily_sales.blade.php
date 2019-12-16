@extends('layout.template')
@section('content')

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Daily Sales</h2>
<div class="row">
    <div class="col-lg-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Daily Sales
            </div>
                <!-- /.panel-heading -->
                
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="companytable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Sales ID</th>
                                        <th>Sale Price</th>
                                        <th>Invoice No</th>
                                        {{-- <th>Discounted Price</th> --}}
                                        <th>Sales Agent</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    {{-- {{dd($sales)}} --}}
                                    @foreach ($dailysales as $sale)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$sale->total_sale}}</td>
                                        <td>{{$sale->sale_invoice}}</td>
                                        {{-- <td>{{$sale->sale_price - (($sale->discount/100)*$sale->sale_price)}}</td> --}}
                                        <td>{{$sale->sale_agent}}</td>
                                        <td>{{date('d-m-Y' , strtotime($sale->sale_date))}}</td>
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
{{-- @if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif --}}
{{-- <h3 align="center" style="font-weight:bold">Generate Reports</h3>
<div class="row">
    <div class="col-lg-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Generate Reports
            </div>
                <!-- /.panel-heading -->
                
            <div class="panel-body">
                <div class="row" align="center">
                    <form action="{{route('gensalesreport')}}" method="post">
                            
                        @csrf
                        <div class="col-lg-4">
                            <div class="col-md-4" >
                                <label for="" class="control-label" style="font-size:large">Customer Name:</label>
                            </div>
                            <div class="col-md-8" >
                                <select class="select2 form-control selectioninput custselect"  style="width:100%;" name="cust_id">
                                    <option></option>
                                    @foreach ($customers as $customer)
                                        <option value="{{$customer->cust_id}}">{{$customer->cust_name}}</option>
                                    @endforeach   
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" >
                            <div class="col-md-4" >
                                <label for="" class="control-label" style="font-size:large">Start Date:</label>
                            </div>
                            <div class="col-md-8" >
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-md-4" >
                                <label for="" class="control-label" style="font-size:large">End Date:</label>
                            </div>
                            <div class="col-md-8" >
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-12" align="center" style="margin-top:20px">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    @endsection