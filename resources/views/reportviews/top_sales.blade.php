@extends('layout.template')
@section('content')
<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Top Sales</h2>
<div class="row">
        <div class="col-lg-12 pagetopmargin">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Top Sales
                </div>
                    <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive table--no-card m-b-30">
                                <table class="table table-striped alldatatables" style="table-layout:fixed" id="companytable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Serial</th>
                                            <th>Medicine Name</th>
                                            <th>Total Quantity Sold</th>
                                            <th>Total Price</th>
                                            {{-- <th>Sales Agent</th> --}}
                                            {{-- <th>Date</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody style="background-color:white; ">
                                        <?php $serial = 1; ?>
                                        {{-- {{dd($sales)}} --}}
                                        @foreach ($topsales as $sale)
                                        <tr>
                                            <td>{{$serial++}}</td>
                                            <td>{{$sale->med_name}}</td>
                                            <td>{{$sale->quantity}}</td>
                                            <td>{{$sale->saleprice}}</td>
                                            {{-- <td>{{$sale->sales_agent}}</td> --}}
                                            {{-- <td>{{date('d-m-Y' , strtotime($sale->created_at))}}</td> --}}
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

    @endsection