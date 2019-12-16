@extends('layout.template2')
@section('content2')
<hr>
<h3>Daily Sales Chart</h3>
<canvas id="myChart" width="100" height="25"></canvas>
<script>
    // var date = new Date().getDate()+1;
    // var month = new Date().getMonth()+1;
    // var year = new Date().getFullYear();
    // var labels = [];
    // var datas = [];
    // for (var i = 0; i>-4; i--){
    //     formated = date-=1
    //     formated += "-"+month+"-"+year;
    //     labels.push(formated);
    // }
    // labels.reverse();
        var filter = ['start','end'];
    $.ajax({
        url: '/allsales/'+filter,
        type: 'get',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            // alert(data['filter3']);
            var labels = [];
            var datas = [];
            len = data.length;
        //   alert(data[0].sale_date);
        //   var values = [];
            for(var i=0; i<len; i++){
                // var a = new Date(data[i].sale_date);
                // alert(a.getMonth+1);
                labels.push(data[i].sale_date);
                datas.push(data[i].dailysales);
        // alert(data[i].sale_date);
            }
            labels.reverse();
            datas.reverse();
     

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'No of Sales',
            data: datas,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                // 'rgba(54, 162, 235, 0.2)',
                // 'rgba(255, 206, 86, 0.2)',
                // 'rgba(75, 192, 192, 0.2)',
                // 'rgba(153, 102, 255, 0.2)',
                // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                // 'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
            //     'rgba(255, 206, 86, 1)',
            //     'rgba(75, 192, 192, 1)',
            //     'rgba(153, 102, 255, 1)',
            //     'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
}
    });
</script>
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

{{-- <div class="row">
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
                                        <th style="width:100px">Invoice No</th>
                                        <th>Medicine Name</th>
                                        <th>Company Name</th>
                                        <th style="width:100px">Category</th>
                                        <th style="width:100px">Quantity</th>
                                        <th style="width:100px">Expiry Date</th>
                                        <th style="width:100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                   
                                    @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$stock->invoice_no}}</td>
                                        <td>{{$stock->med_name}}</td>
                                        <td>{{$stock->company_name}}</td>
                                        <td>{{$stock->cat_name}}</td>
                                        <td>{{$stock->quantity}}</td>
                                        @if($stock->expiry_date != '0000-00-00')
                                            <td>{{date('d-m-Y' , strtotime($stock->expiry_date))}}</td>
                                        @else
                                            <td>{{$stock->expiry_date}}</td>
                                        @endif
                                    
                                        <td>
                                            <div class="btn-group">
                                                <button onClick='deleteStock({{$stock->stock_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button> --}}
                                                {{-- <button class="btn btn-primary">B</button> --}}
                                                {{-- <button class="btn btn-primary">C</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> --}}
                            {{-- <span>{{ $allcasesdata->links() }}</span> --}}
                    {{-- </div>    
                </div>
            </div> --}}
                <!-- /.panel-body -->
        {{-- </div>
    </div>
</div> --}}
    <!-- Stocks Modal -->
{{-- <div class="modal fade" id="deleteStockModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                   Do you really want to delete this case.
               </p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <form method="POST" action="{{ route('deletestock')}}">
                @csrf
                <input hidden type="text" id="idtodel" name="stock_id">
                <input class="btn btn-primary" type="submit" id="submit" value="Confirm">
                </form> --}}
               {{-- <a class="btn btn-primary" href="{{route('deletecase' , Crypt::encrypt($case->case_id))}}">Confirm</a> --}}
           {{-- </div>
       </div>
   </div>
</div> --}}
<!-- Stocks Modal -->
@endsection