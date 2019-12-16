@extends('layout.template')
@section('content')

@if ($errors)
    @foreach ($errors->all() as $message)
        <div class="invalid-feedback" >
            <strong class="errormsg">{{$message}}</strong>
        </div>
    @endforeach
@endif
<div class="row" style="padding-top:20px">
    <div class="col-md-3"></div>
    <div class="col-md-2">
        <label for="validationServer01">Vendor Name</label>
    </div>
    <form action="{{route('addvendorindb')}}" method="post">
        @csrf
    <div class="col-md-3">
        <input type="text" required name="vendor_name" class="form-control is-valid" id="validationServer01" placeholder="Enter Vendor Name">
    </div>
    <div class="col-md-1">
        <input type="submit" class="btn btn-primary" value="submit">
    </div>
    </form>
    <div class="col-md-3"></div>
</div>

<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Purchase Invoice
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="{{route('addpurchaseindb')}}" method="post">
                    @csrf
                    
                        <div class="row inputmargins" align="center">
                            <div class="col-md-2">
                                <label >Invoice No<sup style="color:red">*</sup></label>
                            </div>
                            <div class="col-md-2"> 
                                <input type="text" required  name="invoice_no" class="form-control is-valid " id="validationServer01" placeholder="Enter Invoice No"  >
                            </div>
                        {{-- </div> --}}
                        {{-- <div class="row inputmargins" align="center"> --}}
                            <div class="col-md-2">
                                <label for="validationServer01">Select Vendor<sup style="color:red">*</sup></label>
                            </div>
                            <div class="col-md-2">
                                <select class="select2 form-control selectioninput" required  style="width:100%;" name="fk_vendor_id">
                                    <option></option>
                                    @foreach ($vendors as $vendor)
                                        <option style="font-size:18px" value="{{$vendor->vendor_id}}">{{$vendor->vendor_name}}</option>
                                    @endforeach   
                                </select>
                                {{-- <input type="number" name="total_price" class="form-control is-valid " id="validationServer01" placeholder="Enter Company Name"  > --}}
                            </div>
                        {{-- </div> --}}
                        {{-- <div class="row inputmargins" align="center"> --}}
                            <div class="col-md-2">
                                <label>Date</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="purchase_date" class="form-control is-valid " id="validationServer01"  placeholder="Enter Date"  >
                            </div>    
                        </div>
                        <hr>

                        <table id="purchasetable" class="table table-striped" style="table-layout:fixed">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:4%"></th>
                                        <th>Medicine Name</th>
                                        <th>Last Purchase</th>
                                        <th>Packet Quantity</th>
                                        <th>Items per packet</th>
                                        <th>Packet Price</th>
                                        <th>Unit Purchase Price</th>
                                        {{-- <th>Sale Price</th> --}}
                                        <th>Expiry Date</th>
                                        {{-- <th style="width:10px"></th> --}}
                                    </tr>
                                </thead>
                                <tbody id="medstable" style="background-color:white; ">
                                       {{-- <div class="medicineblock"> --}}
                                        
                                        <tr class="medicineblock">
                                            <td><span onClick="delrow(this)" class="btn delrow" id="delrow" style="background-color:transparent"><i style="color:red" class="fa fa-close"></i></span></td>
                                            <td>
                                                <select class="select2 form-control selectioninput prcmed" required  style="width:100%;"  name="fk_med_id[]">
                                                    <option></option>
                                                    @foreach ($medicines as $medicine)
                                                        <option style="font-size:18px" data-prcprice='[{{$medicine->unit_price}}]' value="{{$medicine->med_id}}">{{$medicine->med_name}}({{$medicine->cat_name}}) - {{$medicine->company_name}} </option>
                                                    @endforeach   
                                                </select>
                                            </td>
                                            <td><input type="number" required name="last_prc[]" readonly class="form-control is-valid prevprc" id="last_prc" placeholder="Last Purchase price"></td>

                                            <td><input type="number" required name="pkt_quantity[]" class="form-control is-valid" id="pkt_quantity" placeholder="Number of Packets"  ></td>
                                            <td><input type="number" required name="quantity_per_pkt[]" value="" class="form-control is-valid purchase_cal quantity_per_pkt" id="quantity_per_pkt" placeholder="Quantity in each packet"  ></td>
                                            <td><input type="number" required name="pkt_price[]" value="" class="form-control is-valid pkt_price purchase_cal" onkeyup="purchasecal()" id="pkt_price" placeholder="Packet purchase price"  ></td>
                                            <td><input type="number" required readonly name="purchse_price[]" value=""  class="form-control is-valid purchse_price" id="purchse_price" placeholder="Unit Purchase Price"  ></td>
                                            {{-- <td><input type="number" required name="sale_price[]" value="0" class="form-control is-valid" id="sale_price" placeholder="Unit Sale Price"  ></td> --}}
                                            <td><input type="date" name="expiry_date[]" class="form-control is-valid" id='expiry_date' placeholder="Enter Expiry Date"></td>
                                        </tr>
                                    {{-- </div> --}}
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                                <div class="row" align="center">
                                    <div class="col-md-4">
                                        <label class="control-label" style="font-size:20px" for="">Courier Charges</label>
                                        <input type="number" value="0" class="form-control is-valid" name="purchase_courier" id="purchase_courier">
                                    </div>
                                </div>
                            <div align="center">
                                <button type="button" style="margin-top:5px"  class="btn btn-primary ml-auto mr-auto" id="addpurchasefield">Add Another Medicine</button>
                            </div>
                                            <script>
                                                $(document).on('keyup' , '.purchase_cal' , function(){
                                                    var pktprice = document.getElementsByName('pkt_price[]');
                                                    var qtperpkt = document.getElementsByName('quantity_per_pkt[]');
                                                    for(var i=0; i < pktprice.length; i++){
                                                        var total = pktprice[i].value / qtperpkt[i].value;
                                                        document.getElementsByName('purchse_price[]')[i].value = total;
                                                    }
                                                // }
                                                });
                                            </script>
                       
                    <div class="row" align="center" style="margin-bottom:20px;">
                        <span class="col-md-12">
                            <button style="margin-top:5px" class="btn btn-primary" type="submit">Submit</button>
                        </span>
                    </div>

                </form>
            </div>
                <!-- /.panel-body -->
        </div>
    </div>
</div>



<script>
  
    $('#addpurchasefield').click(function (){
      $('#purchasetable tr:last').after('<tr class="medicineblock"> <td><span onClick="delrow(this)" class="btn delrow" id="delrow" style="background-color:transparent"><i style="color:red" class="fa fa-close"></i></span></td> <td><select class="select2 form-control selectioninput prcmed" required style="width:100%;"  name="fk_med_id[]"><option></option>@foreach ($medicines as $medicine)<option style="font-size:18px" data-prcprice="[{{$medicine->unit_price}}]" value="{{$medicine->med_id}}">{{$medicine->med_name}}({{$medicine->cat_name}}) - {{$medicine->company_name}} </option>@endforeach   </select></td><td><input type="number" required name="last_prc[]" readonly class="form-control is-valid prevprc" id="last_prc" placeholder="Last Purchase price"></td><td><input type="number" required name="pkt_quantity[]" class="form-control is-valid" id="pkt_quantity" placeholder="Number of Packets"  ></td><td><input type="number" required name="quantity_per_pkt[]" value="" class="form-control is-valid purchase_cal quantity_per_pkt" id="quantity_per_pkt" placeholder="Quantity in each packet"  ></td><td><input type="number" required name="pkt_price[]" value="" class="form-control is-valid pkt_price purchase_cal" id="pkt_price" placeholder="Packet purchase price"  ></td><td><input type="number" required readonly name="purchse_price[]" value=""  class="form-control is-valid purchse_price" id="purchse_price" placeholder="Unit Purchase Price"  ></td><td><input type="date" name="expiry_date[]" class="form-control is-valid" id="expiry_date" placeholder="Enter Expiry Date"></td></tr>');
      $('.select2').select2({
        placeholder: 'Enter Medicine',
      });
    });
  
    function delrow(r){
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("purchasetable").deleteRow(i);
        
    }
</script>
    
@endsection