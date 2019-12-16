@extends('layout.template')
@section('content')

<h2 align="center" style="font-weight:bold; margin-top:0px; padding-top:30px">All Purchases</h2>

<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> All Purchases
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="companytable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Invoice Numbers</th>
                                        <th>Vendor Name</th>
                                        <th>Expensess</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($purchases as $purchase)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td><button class="btn btn-primary" onclick="showMeds({{$purchase}})">{{$purchase->invoice_no}}</button></td>
                                        <td>{{$purchase->vendor_name}}</td>
                                        <td>{{$purchase->total_price}}</td>
                                        <td>{{date('d-m-Y' , strtotime($purchase->purchase_date))}}</td>
                                        <td>
                                        <form action="{{route('deletepurchase')}}" method="post">
                                            @csrf
                                            <input type="number" hidden name="purchase_id" value="{{$purchase->purchase_id}}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        </td>
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

<!-- modal static -->
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog " role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h4 class="modal-title" id="staticModalLabel">Purchase Details</h4>
               <button type="button" class="close modalbtn1" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <div class="row" style="border-bottom:1px solid black">
                    <div class="col-sm-3" id="medname">
                        <label class="control-label" for="">Medicine Name:</label>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="">Total Qty:</label>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="">Unit Price:</label>
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label" for="">Total Price:</label>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="">Action:</label>
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
    function showMeds(val){
        var id = val.purchase_id;
        $.ajax({
            type:'POST',
            url:'/getMeds',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{purchase_id:id , _token: '{{csrf_token()}}'},
            success:function(data){
                $('#dataModal').modal();
                data.forEach(element => {
                    $('.modal-body').append('<div class="row medsrow" style="border-bottom:1px dotted black"><div class="col-sm-3" id="medname"><span>'+element.med_name+'</span></div><div class="col-sm-2"><span>'+(element.unit_quantity * element.subunit_quantity)+'</span></div><div class="col-sm-2"><span>'+element.subunit_price+'</span></div><div class="col-sm-3"><span>'+((element.unit_quantity * element.subunit_quantity)*element.subunit_price)+'</span></div><div class="col-sm-2"><span><form action="{{route('deletepurchase')}}" method="post">@csrf<input type="number" hidden name="med_id" value="'+element.med_id+'"><button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form></span></div></div>')
                });
            }
        });
    }
</script>

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
                console.log(data);
            }
        });
    });
        
    // function geninvoice(){  onclick="geninvoice()"
    //     console.log($(this).parent().siblings('.id'));
    // }
</script>
    
@endsection