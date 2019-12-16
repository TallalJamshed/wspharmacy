@extends('layout.template')
@section('content')

@if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Generate Profit/Loss Reports</h2>
<div class="row">
    <div class="col-lg-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Generate Profit Loss Reports
            </div>
                <!-- /.panel-heading -->
                
            <div class="panel-body">
                <div class="row" align="center">
                    <form action="{{route('plreportdata')}}" method="post">
                            
                        @csrf
                        <div class="col-lg-6" >
                            <div class="col-md-4" >
                                <label for="" class="control-label" style="font-size:large">Start Date:</label>
                            </div>
                            <div class="col-md-8" >
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
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