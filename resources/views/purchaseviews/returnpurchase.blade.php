@extends('layout.template')
@section('content')

@if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Purchase Return</h2>

<div class="row" style="padding:20px">
    <div class="col-md-1"></div>
    <div class="col-md-2">
        <label for="validationServer01">Enter Invoice No</label>
    </div>
    <div class="col-md-3">
        <input type="text" name="invoice_no" class="form-control is-valid" id="invoice_no" placeholder="Enter Invoice No">
    </div>
    <div class="col-md-2">
        <label for="validationServer01">Vendor Name</label>
    </div>
    <div class="col-md-3">
        <input type="text" name="vendor_name" readonly class="form-control is-valid" id="vendor_name" placeholder="Vendor Name">
    </div>
    <div class="col-md-1"></div>
</div>
<div class="row">
    <div class="col-lg-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Purchase Return
            </div>
                <!-- /.panel-heading -->
                
            <div class="panel-body">
                <div class="row" align="center">
                    <form action="{{route('deletepurchase')}}" method="post">    
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
                                        <input type="text" hidden name="purchase_id" class="purchase_id" >
                                        <input type="text" hidden name="vendor_id" class="vendor_id" >
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
                            <button type="submit" class="btn btn-primary">Return Purchase</button>
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
            url:'/getpurchasebyinvoice',
            type: 'POST',
            data:{invoice:invoice_no , _token:'{{csrf_token()}}'},
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            success:function(data){
                if(data['purchase'] != '' ){
                    // console.log(data);
                    $('#tablerows tr').remove();
                    $('#tablerows').append('<tr></tr>')
                    
                    $('#vendor_name').val(data['purchase'][0].vendor_name);
                    $('.purchase_id').val(data['purchase'][0].purchase_id);
                    $('.vendor_id').val(data['purchase'][0].fk_vendor_id);
                data['purchase'].forEach(element => {
                    var padd1 = 0; var padd2 = 0; var sadd = 0; 
                    data['sales'].forEach(element2 => {
                        if (element2.fk_med_id == element.fk_med_id ) {
                            padd1 += element2.quantity_sold - sadd;
                            data['recoveries'].forEach(element3 => {
                                if (element3.fk_sale_detail_id == element2.sale_detail_id ) {
                                    sadd += element3.recovered_amount
                                }
                                
                            });
                            
                            // add += element2.p_recovered_amount;
                        }
                    });
                    data['precoveries'].forEach(element4 => {
                        if (element4.fk_purchase_detail_id == element.purchase_detail_id ) {
                            padd2 += element4.p_recovered_amount;
                        }
                    });
                    // if(padd2 <0 ){
                                // alert(padd2);
                            // }
                    var qty = (element.unit_quantity * element.subunit_quantity);
                    var divs = element.unit_price;
                    // if (!((qty - padd1 - padd2) < 0) ) {
                        $('#tablerows').append('<tr><td><span onClick="delrow(this)" class="btn delrow" id="delrow" style="background-color:transparent"><i style="color:red" class="fa fa-close"></i></span></td><td><input type="text" hidden name="purchase_detail_id[]" value='+element.purchase_detail_id+'></td><td><input type="text" hidden name="unit_price[]" value='+divs+'></td><td><input type="text" hidden name="quty[]" value='+(qty - padd1 - padd2)+'></td><td><input type="text" hidden name="med_id[]" value='+element.med_id+'></td><td>'+element.med_name+'</td><td>'+divs+'</td><td>'+((qty - padd1 - padd2) * divs)+'</td><td>'+(qty - padd1 - padd2)+'</td><td><input type="text" name="rt_qty[]" class="form-control" placeholder="Returning Quantity"></td></tr>');  
                    // }
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