@extends('layout.template')
@section('content')

@if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Generate Sales Reports</h2>
<div class="row">
    <div class="col-lg-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Generate Sales Reports
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
</div>

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Generate Purchase Reports</h2>
<div class="row">
    <div class="col-lg-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Generate Purchase Reports
            </div>
                <!-- /.panel-heading -->
                
            <div class="panel-body">
                <div class="row" align="center">
                    <form action="{{route('genpurchasereport')}}" method="post">
                            
                        @csrf
                        <div class="col-lg-4">
                            <div class="col-md-4" >
                                <label for="" class="control-label" style="font-size:large">Vendor Name:</label>
                            </div>
                            <div class="col-md-8" >
                                <select class="select2 form-control selectioninput custselect"  style="width:100%;" name="vendor_id">
                                    <option></option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{$vendor->vendor_id}}">{{$vendor->vendor_name}}</option>
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
</div>

    @endsection