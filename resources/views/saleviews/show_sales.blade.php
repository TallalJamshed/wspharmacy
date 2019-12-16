@extends('layout.template')
@section('content')

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">All Sales</h2>

<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> All Sales
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            {{-- <form action="" method="post"> --}}
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="companytable">
                                <thead class="thead-dark">
                                    <tr>
                                        {{-- <th style="text-align:center">Sales ID</th> --}}
                                        <th style="text-align:center">Invoice No</th>
                                        <th style="text-align:center">Sale Price</th>
                                        {{-- <th>Discount</th> --}}
                                        <th style="text-align:center">Customer Name</th>
                                        <th style="text-align:center">Sales Agent</th>
                                        <th style="text-align:center">Date</th>
                                        <th style="text-align:center">Generate Invoice</th>
                                        {{-- <th style="text-align:center;">Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody style="background-color:white;">
                                    @foreach ($sales as $sale)
                                    <tr>
                                        {{-- <td style="text-align:center">{{$sale->sale_id}}</td> --}}
                                        <td class="id" style="text-align:center"><button class="btn btn-primary" onclick="showSaleMeds({{$sale}})">{{$sale->sale_invoice}}</button></td>
                                        <td style="text-align:center">{{$sale->total_sale}}</td>
                                        {{-- <td>{{$sale->discount}}</td> --}}
                                        <td style="text-align:center">{{$sale->cust_name}}</td>
                                        <td style="text-align:center">{{$sale->sale_agent}}</td>
                                        <td style="text-align:center">{{date('d-m-Y' , strtotime($sale->sale_date))}}</td>
                                        <td style="text-align:center">
                                            {{-- <button class="btn btn-primary geninvoice" name="geninvoice" >geninvoice</button> --}}
                                        <form action="{{route('gensaleinvoice')}}" method="post">
                                            @csrf
                                            <input type="number" hidden name="invoice_no" value="{{$sale->sale_invoice}}">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <span class="glyphicon glyphicon-print"></span> Invoice
                                            </button>
                                        </form>
                                        </td>
                                        {{-- <td align="center">
                                            <button onClick='deleteInvoice({{$sale->sale_invoice}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- </form> --}}
                        </div>
                            {{-- <span>{{ $allcasesdata->links() }}</span> --}}
                    </div>    
                </div>
            </div>
                <!-- /.panel-body -->
        </div>
    </div>
</div>
<script>
    $('.geninvoice').click(function(){
        // console.log($(this).parent().siblings('.id').html());
        var id = $(this).parent().siblings('.id').html();
        $.ajax({
            type:'POST',
            url:'/gensaleinvoice',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{invoice_no:id , _token: '{{csrf_token()}}'},
            success:function(data){
                // console.log(data);
            }
        });
    });
</script>
<!-- modal static -->
<div class="modal fade" id="dataSaleModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticModalLabel">Sale Details</h4>
                <button type="button" class="close modalbtn1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="border-bottom:1px solid black">
                     <div class="col-sm-3" id="medname">
                         <label class="control-label" for="">Medicine Name:</label>
                     </div>
                     <div class="col-sm-3">
                         <label class="control-label" for="">Total Quantity:</label>
                     </div>
                     <div class="col-sm-3">
                         <label class="control-label" for="">Unit Price:</label>
                     </div>
                     <div class="col-sm-3">
                        <label class="control-label" for="">Total Price:</label>
                    </div>
                </div>
            </div>
         </div>
         <div class="modal-footer">
             <div align="center"> 
                 <button id="exitbutton" class="btn btn-secondary modalbtn1" data-dismiss="modal">Cancel</button>
             </div>
         </div>
     </div>
 </div>
 <!-- end modal static -->
<script>
    function showSaleMeds(val){
        // console.log(val.sale_id);
        var id = val.sale_id;
        $.ajax({
            type:'POST',
            url:'/getSaleMeds',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{sale_id:id , _token: '{{csrf_token()}}'},
            success:function(data){
                // console.log(data)
                $('#dataSaleModal').modal();
                data.forEach(element => {
                    $('.modal-body').append('<div class="row medsrow" style="border-bottom:1px dotted black"><div class="col-sm-3" id="medname"><span>'+element.med_name+'</span></div><div class="col-sm-3"><span>'+(element.quantity_sold)+'</span></div><div class="col-sm-3"><span>'+(element.price / element.quantity_sold)+'</span></div><div class="col-sm-3"><span>'+element.price+'</span></div></div>')
                });
                // console.log(data);
            }
        });
    }
</script>
    
@endsection