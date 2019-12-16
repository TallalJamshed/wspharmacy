@extends('layout.template')
@section('content')

@if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Sales Return</h2>

<div class="row" style="padding:20px">
    <div class="col-md-1"></div>
    <div class="col-md-2">
        <label for="validationServer01">Enter Invoice No</label>
    </div>
    <div class="col-md-3">
        <input type="text" name="invoice_no" class="form-control is-valid" id="invoice_no" placeholder="Enter Invoice No">
    </div>
    <div class="col-md-2">
        <label for="validationServer01">Customer Name</label>
    </div>
    <div class="col-md-3">
        <input type="text" name="cust_name" readonly class="form-control is-valid" id="cust_name" placeholder="Customer Name">
    </div>
    <div class="col-md-1"></div>
</div>
<div class="row">
    <div class="col-lg-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Sales Return
            </div>
                <!-- /.panel-heading -->
                
            <div class="panel-body">
                <div class="row" align="center">
                    <form action="{{route('deletesales')}}" method="post">    
                        @csrf
                        
                        <div class="col-lg-12">
                            <div class="table-responsive table--no-card m-b-30">
                                <table class="table table-striped" id="returnstable" style="table-layout:fixed" >
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:3%"></th>
                                            <th style="width:1px"></th>
                                            <th style="width:1px"></th>
                                            <th style="width:1px"></th>

                                            <th>Medicine Name</th>
                                            <th>Unit Price</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Returning Qty</th>
                                            {{-- <th>Returning Price</th> --}}
                                            {{-- <th style="width:150px">Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody style="background-color:white; " id="tablerows">
                                        <input type="text" hidden name="sale_id" class="sale_id" >
                                        <input type="text" hidden name="cust_id" class="cust_id" >
                                        <tr>
                                            {{-- <td><input type="text" name="med_id" value=""></td>
                                            <td></td>
                                            <td></td>
                                            <td><input type="text" name="rt_qty" class="form-control" placeholder="Returning Quantity"></td>
                                            <td><input type="text" name="rt_price[]" value=0 class="form-control" placeholder="Returning Price"></td> --}}

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                                {{-- <span>{{ $allcasesdata->links() }}</span> --}}
                        </div>    
                        
                        <div class="col-md-12" align="center" style="margin-top:20px">
                            <button type="submit" class="btn btn-primary">Return Sales</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#invoice_no').keyup(function(){
        var invoice_no = $('#invoice_no').val();
        if(invoice_no != ''){
        $.ajax({
            url:'/getsalebyinvoice',
            type: 'POST',
            data:{invoice:invoice_no , _token:'{{csrf_token()}}'},
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            success:function(data){
                if(data['sales'] != ''){
                    // console.log(data['sales'][0].cust_name);
                    $('#tablerows tr').remove();
                    $('#tablerows').append('<tr></tr>')
                    
                    $('#cust_name').val(data['sales'][0].cust_name);
                    $('.sale_id').val(data['sales'][0].sale_id);
                    $('.cust_id').val(data['sales'][0].fk_cust_id);
                data['sales'].forEach(element => {
                    var add = 0;
                    data['recoveries'].forEach(element2 => {
                        if (element2.fk_sale_detail_id == element.sale_detail_id ) {
                            add += element2.recovered_amount;
                        }
                    });
                    var divs = (element.price/element.quantity_sold);
                    $('#tablerows').append('<tr><td><span onClick="delrow(this)" class="btn delrow" id="delrow" style="background-color:transparent"><i style="color:red" class="fa fa-close"></i></span></td><td><input type="text" hidden name="sale_detail_id[]" value='+element.sale_detail_id+'></td><td><input type="text" hidden name="unit_price[]" value='+divs+'></td><td><input type="text" hidden name="med_id[]" value='+element.med_id+'></td><td>'+element.med_name+'</td><td>'+divs+'</td><td>'+((element.quantity_sold - add) * divs)+'</td><td>'+(element.quantity_sold - add)+'</td><td><input type="text" name="rt_qty[]" class="form-control" placeholder="Returning Quantity"></td></tr>');
                    // $('#rt_price').val(divs);
                    // console.log(element.price)
                });
                }else{
                    $('#tablerows tr').remove();
                    $('#tablerows').append('<tr></tr>')
                }
            }
        });
        }else{
            $('#tablerows tr').remove();
            $('#tablerows').append('<tr></tr>')
        }
    });

    function delrow(r){
        var i = r.parentNode.parentNode.rowIndex;
        // alert(i);
        document.getElementById("returnstable").deleteRow(i);
        
        // var total = 0;
        // var prices = document.getElementsByName('total_price[]');
        // for(var i=0; i < prices.length; i++){
        //     total +=  parseFloat(prices[i].value);
        //     document.getElementById('total').value = total;
        // }
    }
</script>
    @endsection