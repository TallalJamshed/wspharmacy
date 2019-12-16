
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3 huge">
                                {{count($data['stocks'])}}
                            {{-- <i class="fa fa-comments fa-5x"></i> --}}
                        </div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size:3rem">Total Stocks</div>
                            {{-- <div>Add New Sales!</div> --}}
                        </div>
                    </div>
                </div>
                <a href="{{ route('showstocks')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3 huge">
                            {{-- <i class="fa fa-tasks fa-5x"></i> --}}
                            {{ $data['sales']}}
                        </div>
                        <div class="col-xs-9 text-right">
                            <div  style="font-size:3rem">Total Sales</div>
                            {{-- <div>Add New Purchases!</div> --}}
                        </div>
                    </div>
                </div>
                <a href="{{route('dailysalesreport')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3 huge">
                            {{-- <i class="fa fa-support fa-5x"></i> --}}
                            {{ $data['purchases']}}
                        </div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size:3rem">Total Purchases</div>
                            {{-- <div>Support Tickets!</div> --}}
                        </div>
                    </div>
                </div>
                <a href="{{ route('addpurchaseform')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        {{-- <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3 huge"> --}}
                            {{-- <i class="fa fa-shopping-cart fa-5x"></i> --}}
                            {{-- {{ $data['expires']}}
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">Expired Medicine</div> --}}
                            {{-- <div>New Orders!</div> --}}
                        {{-- </div>
                    </div>
                </div>
                <a href="{{route('expiredmeds')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div> --}}
        
    </div>
    <!-- /.row -->