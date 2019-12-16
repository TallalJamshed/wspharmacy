@extends('layout.template')
@section('content')

@if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif

<div class="row container" style="padding-top:20px">
    {{-- <div class="col-md-3"></div> --}}
    <form action="{{route('addcustomerindb')}}" method="post">
            @csrf

    <div class="col-md-2">
        <label for="validationServer01">Customer Category</label>
    </div>
    <div class="col-md-2">
        <select class="form-control selectioninput" required style="width:100%;" name="fk_cust_cat_id">
            <option></option>
            @foreach ($cust_cat as $categories)
                <option value="{{$categories->cust_cat_id}}">{{$categories->cust_cat_name}}</option>
            @endforeach   
        </select>
    </div>

    <div class="col-md-2">
        <label for="validationServer01">Customer Name</label>
    </div>
    <div class="col-md-2">
        <input type="text" required name="cust_name" class="form-control is-valid" id="validationServer01" placeholder="Customer Name">
    </div>

    <div class="col-md-2">
        <label for="validationServer01">Customer Address</label>
    </div>
    <div class="col-md-2">
        <input type="text" name="cust_address" class="form-control is-valid" id="validationServer01" placeholder="Customer Address">
    </div>  
    {{-- <div class="col-md-1">
        <input type="submit" class="btn btn-primary" value="submit">
    </div> --}}
    <div class="row"  align="center">
        <input style="margin-top:20px" type="submit" class="btn btn-primary" value="submit">
    </div>
    </form>

    {{-- <div class="col-md-3"></div> --}}
</div>
{{-- <div class="row">
    <hr>
    <div class="col-md-12" style="margin-top:20px; margin-bottom:-20px">
        <div class="col-md-2" align="center">
            <label for="" class="control-label">Search Formula</label>
        </div>
        <div class="col-md-4">
            <select class="select2 form-control formulaselection" aria-readonly="true" style="width:100%;" name="fk_formula_id[]">
                <option></option>
                    @foreach ($formulas as $formula)
                        <option value="{{$formula->formula_id}}">{{$formula->formula_name}}</option>
                    @endforeach   
            </select>
        </div>
        <div class="col-md-2" align="center">
            <label for="" class="control-label">Medicines</label>
        </div>
        <div class="col-md-4" id="showmeds">
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Sales
            </div>
                <!-- /.panel-heading -->  
                <div id="test"></div> 
            <div class="panel-body">
                <form action="{{route('addsalesindb')}}" method="post">
                    @csrf

                    <div class="row" align="center" style="background-color:#f9f9f9; border-top:2px solid #ddd; padding:8px">
                        {{-- <div class="col-md-3"></div> --}}
                        <div class="col-md-2">
                            <label for="">Select Customer</label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control selectioninput" required style="width:100%;" name="fk_cust_id">
                                <option></option>
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->cust_id}}">{{$customer->cust_name}}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Select Sale Date</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" id="sale_date" name="sale_date" class="form-control is-valid">
                        </div>
                        
                    </div>
                    <hr>
                    <table id="medstable" class="table table-striped " style="table-layout:fixed" >
                            <thead class="thead-dark">
                                <tr>
                                        {{-- <th style="width:10px"></th> --}}
                                    <th style="width:4%"></th>
                                    <th>Medicine Name</th>
                                    <th>Purchase Price</th>
                                    <th>Sale Price</th>
                                    <th>Available Quantity</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="meds_body" style="background-color:white; ">
                                   {{-- <div class="medicineblock"> --}}
                                    
                                    <tr class="medicineblock">
                                        <td><span onClick="delrow(this)" class="btn delrow" id="delrow" style="background-color:transparent"><i style="color:red" class="fa fa-close"></i></span></td>
                                        <td>
                                            <select class="select2 form-control selectioninput medselect" required style="width:100%;" name="fk_med_id[]">
                                                <option></option>
                                                @foreach ($medicines as $medicine)
                                                
                                            <option data-saleprice='{{$medicine['sale_price']}}' data-quantity='{{$medicine['total_quantity']}}' value="{{$medicine['med_id']}}">{{$medicine['med_name']}}({{$medicine['cat_name']}}) - {{$medicine['company_name']}} </option>
                                                @endforeach   
                                            </select>
                                        </td>
                                        <td><input type="number" required readonly name="price[]" class="form-control is-valid actual_price" id="price" placeholder="Actual Price"  ></td>
                                        <td><input type="number" required name="sale_price[]" class="form-control is-valid pkt_price sale_cal" id="pkt_price" placeholder="Sale price"  ></td>
                                        <td><input type="number" required readonly name="available_quantity[]" class="form-control is-valid total_quantity" id="total_quantity" placeholder="Available Quantity"></td>
                                        <td>
                                            <input type="number" required name="sale_quantity[]"  class="form-control is-valid sale_quantity sale_cal" id="sale_quantity" placeholder="Sale Quantity">
                                            <span class="warning" style="color:red; font-size:12px" name="warning[]" id="warning"></span>
                                        </td>
                                        <td><input type="text" required readonly name="total_price[]" class="form-control is-valid totalprice" id="sale_price" placeholder="Total Price"  ></td>
                                        <input type="hidden" name="actual_quantity[]" id="actual_quantity">
                                    </tr>
                                </tbody>
                            </table>          
        
                            <hr style="border:0.5px solid black">
                
                <div class="row inputmargins" align="center">
                    {{-- <button type="button" class="btn btn-danger" id="del"><i class="fa fa-trash"></i></button> --}}
                    {{-- <button type="button" class="btn btn-danger" id="cal">Calculate Total Price</button> --}}
                    <button type="button" class="btn btn-primary" id="addfield">Add Another Medicine</button>
                </div>
                <div class="row" align="center">
                    <div class="col-md-4">
                        <label class="control-label" style="font-size:20px" for="">Total Bill</label>
                        <input class="form-control" required readonly name="total_sale"  style="width:80%" type="number" id="total" placeholder="Total Bill">
                    </div>
                    <div class="col-md-4">
                        <label class="control-label" style="font-size:20px" for="">Courier Service</label>
                        <input class="form-control" name="courier_service" value="0" style="width:80%" type="number" id="courier_service">
                    </div>
                    {{-- <div class="col-md-4">
                        <label class="control-label" style="font-size:20px" for="">Discounted Bill</label>
                        <input class="form-control" readonly name="discountedbill" value="0" style="width:80%" type="number" id="discountedbill">
                    </div> --}}
                </div>
                <hr>
                <div class="row" align="center" style="margin-bottom:20px;">
                    <span class="col-md-12">
                        <button id="salesubmit" style="margin-top:5px" class="btn btn-danger" type="submit">Submit</button>
                    </span>
                </div>
            </form>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> All Customers
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="customertable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:150px">Serial Number</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Customer Phone No</th>
                                        <th>Customer Address</th>
                                        <th>Customer Category</th>
                                        <th style="width:150px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$customer->cust_name}}</td>
                                        <td>{{$customer->cust_email}}</td>
                                        <td>{{$customer->cust_phoneno}}</td>
                                        <td>{{$customer->cust_address}}</td>
                                        <td>{{$customer->cust_cat_name}}</td>
                                        <td>
                                            <button onClick='deleteCustomer({{$customer->cust_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
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

 <!-- Stocks Modal -->
 <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                    Do you really want to delete this customer.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('deletecustomer')}}">
                 @csrf
                 <input hidden type="text" id="customeridtodel" name="cust_id">
                 <input class="btn btn-primary" type="submit" id="submit" value="Confirm">
                 </form>
                {{-- <a class="btn btn-primary" href="{{route('deletecase' , Crypt::encrypt($case->case_id))}}">Confirm</a> --}}
            </div>
        </div>
    </div>
 </div>
 <!-- Stocks Modal -->

<script>
  
    $('#addfield').click(function (){
      $('#medstable tr:last').after('<tr class="medicineblock"><td><span onClick="delrow(this)" class="btn delrow" id="delrow" style="background-color:transparent"><i style="color:red" class="fa fa-close"></i></span></td><td><select class="select2 form-control selectioninput" required style="width:100%;" name="fk_med_id[]"><option></option>@foreach ($medicines as $medicine)<option data-saleprice="{{$medicine["sale_price"]}}" data-quantity="{{$medicine["total_quantity"]}}" value="{{$medicine["med_id"]}}">{{$medicine["med_name"]}}({{$medicine["cat_name"]}}) - {{$medicine["company_name"]}} </option>@endforeach   </select></td><td><input type="number" required readonly name="price[]" class="form-control is-valid actual_price" id="price" placeholder="Actual Price"  ></td><td><input type="number" required name="sale_price[]" class="form-control is-valid pkt_price sale_cal" id="pkt_price" placeholder="Sale Price"  ></td> <td><input type="number" required readonly name="available_quantity[]" class="form-control is-valid total_quantity" id="total_quantity" placeholder="Available Quantity"></td> <td><input type="number" required name="sale_quantity[]"  class="form-control is-valid sale_quantity sale_cal" id="sale_quantity" placeholder="Sale Quantity"><span class="warning" style="color:red; font-size:12px" name="warning[]" id="warning"></span></td><td><input type="text" required readonly name="total_price[]" class="form-control is-valid totalprice" id="sale_price" placeholder="Total Price"  ></td><input type="hidden" name="actual_quantity[]" id="actual_quantity"></tr>');
      $('.selectioninput').select2({
        placeholder: 'Enter Medicine',
      });
    });

    function delrow(r){
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("medstable").deleteRow(i);
        
        var total = 0;
        var prices = document.getElementsByName('total_price[]');
        for(var i=0; i < prices.length; i++){
            total +=  parseFloat(prices[i].value);
            document.getElementById('total').value = total;
        }
    }
    
  
</script>
    
@endsection