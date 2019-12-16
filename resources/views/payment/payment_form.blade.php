@extends('layout.template')
@section('content')
{{-- @include('partials.cards') --}}
@if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif
<h3 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">Customer Payment Recieving Form</h3>
@if ($errors->has('cat_name'))
    <div class="invalid-feedback" >
        <strong class="errormsg">{{$errors->first('cat_name')}}</strong>
    </div>
@endif

<div class="row" >
    <div class="col-lg-12 pagetopmargin" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i>Add Payment
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                    <div class="row" align="center" style="margin-top:10px">
                            <div class="col-md-2">
                                <label for="validationServer01">Search By Invoice No</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="search_invoice" name="search_invoice" class="form-control is-valid"  placeholder="Enter Invoice Number"  >
                            </div>  
                            <div class="col-md-2">
                                <label for="validationServer01">Search By Customer Name</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control cust_name" id="search_cust" style="width:100%;" name="search_cust">
                                    <option></option>
                                        @foreach ($customers as $customer)
                                            <option value="{{$customer->cust_id}}">{{$customer->cust_name}}</option>
                                        @endforeach   
                                </select>
                                {{-- <input type="text" id="cust_name2" name="cust_name2" hidden class="form-control is-valid"  placeholder="Customer Name"  > --}}
                            </div>  
                        </div>
                <hr>
                <form action="{{route('addpaymentindb')}}" method="post">
                    @csrf
                    <input type="text" required hidden name="ledger_id" id="ledger_id">
                    <div class="row" align="center" style="margin-top:10px">
                        {{-- <div class="col-md-2">
                            <label for="validationServer01">Invoice No</label>
                        </div> --}}
                        {{-- <div class="col-md-4">
                            <input type="text" readonly id="invoice_no" name="invoice_no" class="form-control is-valid"  placeholder="Enter Invoice Number"  >
                        </div>   --}}
                        <div class="col-md-2">
                            <label for="validationServer01">Customer Name</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" required readonly id="cust_name" name="cust_name" class="form-control is-valid"  placeholder="Customer Name"  >
                        </div>  

                        <div class="col-md-2">
                            <label for="validationServer01">Payment Date</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" id="payment_date" name="payment_date" class="form-control is-valid" >                        
                        </div>
                        
                        
                    </div>

                    <div class="row" align="center" style="margin-top:10px">
                        <div class="col-md-2">
                            <label for="validationServer01">Total Bill</label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" required id="total_bill" name="total_bill" readonly class="form-control is-valid"  placeholder="Total Bill"  >
                        </div>

                        <div class="col-md-2">
                            <label for="validationServer01">Paid Amount</label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" required id="payment" name="payment" value="0" class="form-control is-valid"  placeholder="Enter Paid Amount"  >
                        </div>
                          
                    </div>

                    <div class="row" align="center" style="margin-top:10px"> 

                        <div class="col-md-2">
                            <label for="validationServer01">Courier Charges</label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" required id="courier" name="courier" readonly class="form-control is-valid"  placeholder="Courier charges"  >
                        </div>
                        
                        <div class="col-md-2">
                            <label for="validationServer01">Courier Payment</label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" required id="courier_paid" name="courier_paid" value="0" class="form-control is-valid"  placeholder="Courier charges Paid"  >
                        </div>
 
                    </div>

                    <div class="row" align="center" style="margin-top:10px"> 

                        <div class="col-md-2">
                            <label for="validationServer01">Discount</label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" required id="discount" name="discount" value="0" class="form-control is-valid"  placeholder="Enter Discount"  >
                        </div>

                    </div>
                    <hr>
                    <div class="container">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped paymentdatatable" style="table-layout:fixed" id="categorytable">
                                <thead class="thead-dark">
                                    <tr>
                                        {{-- <th>Serial</th> --}}
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Discount</th>
                                        <th>Remaining Amount</th>
                                        <th>Courier Paid</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody id="payment-table" style="background-color:white; ">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row" align="center" style="margin-bottom:20px;">
                        <span class="col-md-12">
                            <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                        </span>
                    </div>    
                </form>
            </div>
                <!-- /.panel-body -->
        </div>
    </div>
</div>

<script>
    var invoice = $('#search_invoice');
    invoice.keyup(function(){
        $.ajax({
            url: '/getbyinvoice',
            type: 'post',
            datatype: 'json',
            data:{invoice:invoice.val() , _token: '{{csrf_token()}}'},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){
                // console.log(data);
                if(data.length != 0){
                    $('#ledger_id').val(data.ledger.ledger_id);
                    // $('#cust_name option:selected').removeAttr("selected").change();
                    // $('#cust_name option[value='+data.ledger.cust_id+']').prop('selected',true).change();
                    $('#invoice_no').val(data.ledger.sale_invoice);
                    $('#cust_name').val(data.ledger.cust_name);
                    $('#courier').val(data.courier);
                    $('#total_bill').val(data.remaining);
                    $('#payment-table tr').remove();
                    data.ledger_details.forEach(element => {
                        var remain = element['remaining_amount']-element['discount'];
                        $('#payment-table').append('<tr><td>'+element['total_amount']+'</td><td>'+element['paid_amount']+'</td><td>'+element['discount']+'</td><td>'+remain+'</td><td>'+element['courier_paid']+'</td><td>'+element['payment_date']+'</td></tr>')
                        // console.log(element['ledger_details_id']);
                    });
                    // console.log(data);
                }else{
                    $('#ledger_id').val('');
                    // $('#cust_name option:selected').removeAttr("selected").change();
                    $('#invoice_no').val('');
                    $('#cust_name').val('');
                    $('#total_bill').val('');
                    $('#courier').val('');
                    $('#payment-table tr').remove();
                }
            }
        });
    });
</script>
<script>
    // $(document).on('change' , '.cust_name' , function(){
    //     alert('helo');
    // });
    // var cust_name = $('#cust_name');
    // $('.cust_name').change(function(){
    //     alert();
        // $.ajax({
        //     url: '/getbycust',
        //     type: 'post',
        //     datatype: 'json',
        //     data:{invoice:invoice.val() , _token: '{{csrf_token()}}'},
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     success:function(data){
        //         if(data.length != 0){
        //             $('#ledger_id').val(data.ledger.ledger_id);
        //             $('#cust_name').val(data.ledger.cust_name);
        //             $('#total_bill').val(data.remaining);
        //             $('#payment-table tr').remove();
        //             data.ledger_details.forEach(element => {
        //                 $('#payment-table').append('<tr><td>'+element['total_amount']+'</td><td>'+element['paid_amount']+'</td><td>'+element['remaining_amount']+'</td><td>'+element['created_at']+'</td></tr>')
        //                 // console.log(element['ledger_details_id']);
        //             });
        //             // console.log(data);
        //         }else{
        //             $('#ledger_id').val('');
        //             $('#cust_name').val('');
        //             $('#total_bill').val('');
        //             $('#payment-table tr').remove();
        //         }
        //     }
        // });
    // });
</script>
    
@endsection