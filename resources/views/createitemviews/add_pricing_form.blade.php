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
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Prices
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="{{route('addpricingindb')}}" method="post">
                    @csrf
                    <div class="row inputmargins" align="center">
                        <div class="col-md-2">
                            <label for="validationServer01">Select Medicine</label>
                        </div>
                        <div class="col-md-4">
                                {{-- <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Enter Company Name"  required> --}}
                            <select class="form-control pricingselect" required style="width:100%;" id="meds" name="fk_med_id">
                                <option></option>
                                @foreach ($medicines as $medicine)
                            <option value="{{$medicine->med_id}}">{{$medicine->med_name}}</option>
                                @endforeach   
                            </select>
                        </div>
                    {{-- </div> --}}
                    {{-- <div class="row inputmargins" align="center"> --}}
                        {{-- <div class="col-md-2">
                            <label for="validationServer01">Recent Purchase Price</label>
                        </div>
                        <div class="col-md-2" style="padding-left:0px">
                               <ul style="list-style:none; padding:0px 0px 0px 0px">
                                   <li>{{}} <b>-on-</b> 12/3/2019</li>
                               </ul>
                        </div> --}}
                    {{-- </div> --}}

                    {{-- <div class="row inputmargins" align="center"> --}}
                        <div class="col-md-2">
                            <label for="validationServer01">Sale Price</label>
                        </div>
                        <div class="col-md-4">
                                <input type="number" required class="form-control is-valid" name="sale_price" id="sale_price" placeholder="Enter Selling Price">
                            {{-- <select class="formulaselect form-control" style="width:100%;" required  name="fk_formula_id" placeholder="Enter medicine formula"> --}}
                                {{-- <option ></option> --}}
                                {{-- @foreach ($formulas as $formula)
                                    <option value="{{$formula->formula_id}}">{{$formula->formula_name}}</option>
                                @endforeach    --}}
                            {{-- </select> --}}
                        </div>
                    </div>

                    {{-- <div class="row inputmargins" align="center">
                        <div class="col-md-2">
                            <label for="validationServer01">Category</label>
                        </div>
                        <div class="col-md-8"> --}}
                                {{-- <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Enter Company Name"  required> --}}
                            {{-- <select class="catselect form-control"  style="width:100%;" required name="fk_med_cat_id">
                                <option></option> --}}
                                {{-- @foreach ($categories as $category)
                                    <option value="{{$category->cat_id}}">{{$category->cat_name}}</option>
                                @endforeach    --}}
                            {{-- </select>
                        </div>    
                    </div> --}}
                    <hr>
                   <div class="row" align="center" style="margin-bottom:20px; margin-top:20px;">
                        <span class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
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
                <i class="fa fa-bar-chart-o fa-fw"></i> All Prices
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="medstable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Medicine Name</th>
                                        <th >Price</th>
                                        {{-- <th>Company Name</th> --}}
                                        {{-- <th>Category</th> --}}
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($pricings as $pricing)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$pricing->med_name}}</td>
                                        <td>{{$pricing->sale_price}}</td>
                                        {{-- <td>{{$medicine->company_name}}</td>
                                        <td>{{$medicine->cat_name}}</td> --}}
                                        {{-- <td>
                                            <button onClick='deleteMedicine({{$pricing->med_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
                                        </td> --}}
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
<div class="modal fade" id="deleteMedicineModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                   Do you really want to delete this medicine.
               </p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <form method="POST" action="{{ route('deletemedicine')}}">
                @csrf
                <input hidden type="text" id="medicineidtodel" name="med_id">
                <input class="btn btn-primary" type="submit" id="submit" value="Confirm">
                </form>
               {{-- <a class="btn btn-primary" href="{{route('deletecase' , Crypt::encrypt($case->case_id))}}">Confirm</a> --}}
           </div>
       </div>
   </div>
</div>
<!-- Stocks Modal -->

@endsection