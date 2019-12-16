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
<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Vendor
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="{{route('addvendorindb')}}" method="post">
                    @csrf
                    {{-- <div class="row" align="center" style="margin-top:10px">
                        <div class="col-md-4">
                            <label for="validationServer01">Customer Category<sup style="color:red">*</sup></label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control selectioninput" required style="width:100%;" name="fk_cust_cat_id">
                                <option></option>
                                @foreach ($cust_cat as $categories)
                                    <option value="{{$categories->cust_cat_id}}">{{$categories->cust_cat_name}}</option>
                                @endforeach   
                            </select>
                        </div>
                    </div> --}}

                    <div class="row" align="center" style="margin-top:10px">
                        <div class="col-md-2">
                            <label for="validationServer01">Vendor Name<sup style="color:red">*</sup></label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" required name="cust_name" class="form-control is-valid" id="validationServer01" placeholder="Enter Customer Name">
                        </div>
                        <div class="col-md-2">
                            <label for="validationServer01">Customer Email</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text"  name="cust_email" class="form-control is-valid" id="validationServer01" placeholder="Enter Customer Email">
                        </div> 
                    </div>
                    <div class="row" align="center" style="margin-top:10px">
                        <div class="col-md-2">
                            <label for="validationServer01">Customer Phone No<sup style="color:red">*</sup></label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" required name="cust_phoneno" class="form-control is-valid" id="validationServer01" placeholder="Enter Customer Phone No">
                        </div>
                        <div class="col-md-2">
                            <label for="validationServer01">Customer Address</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="cust_address" class="form-control is-valid" id="validationServer01" placeholder="Enter Customer Address">
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
                    Do you really want to delete this case.
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


    
@endsection