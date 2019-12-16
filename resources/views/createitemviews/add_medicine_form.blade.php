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
    <div class="panel-body">
        <form action="{{route('addformulaindb')}}" method="post">
            @csrf
            
            <div class="row inputmargins" align="center">
                <div class="col-md-2">
                    <label for="validationServer01">Formula Name</label>
                </div>
                <div class="col-md-8">
                    <input type="text" required name="formula_name" class="form-control is-valid" id="validationServer01" placeholder="Enter Formula Name"  >
                </div>
            </div>
           
            <hr>
            <div class="row" align="center" style="margin-bottom:20px;">
                <span class="col-md-12">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </span>
            </div>

        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Medicine
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="{{route('addmedicineindb')}}" method="post">
                    @csrf
                    <div class="row inputmargins" align="center">
                        <div class="col-md-2">
                            <label for="validationServer01">Medicine Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" required name="med_name" class="form-control is-valid" id="validationServer01" placeholder="Enter Medicine Name"  >
                        </div>
                    </div>
                    <div class="row inputmargins" align="center">
                        <div class="col-md-2">
                            <label for="validationServer01">Company Name</label>
                        </div>
                        <div class="col-md-8">
                                {{-- <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Enter Company Name"  required> --}}
                            <select class="companyselect form-control" style="width:100%;"  name="fk_company_id" placeholder="Please Enter The Company First">
                                <option ></option>
                                @foreach ($companies as $company)
                                    <option value="{{$company->company_id}}">{{$company->company_name}}</option>
                                @endforeach   
                            </select>
                        </div>
                    </div>

                    <div class="row inputmargins" align="center">
                        <div class="col-md-2">
                            <label for="validationServer01">Formula</label>
                        </div>
                        <div class="col-md-8">
                                {{-- <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Enter Company Name"  required> --}}
                            <select class="formulaselect form-control" style="width:100%;"  name="fk_formula_id" placeholder="Enter medicine formula">
                                <option ></option>
                                @foreach ($formulas as $formula)
                                    <option value="{{$formula->formula_id}}">{{$formula->formula_name}}</option>
                                @endforeach   
                            </select>
                        </div>
                    </div>

                    <div class="row inputmargins" align="center">
                        <div class="col-md-2">
                            <label for="validationServer01">Category</label>
                        </div>
                        <div class="col-md-8">
                                {{-- <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Enter Company Name"  required> --}}
                            <select class="catselect form-control" required style="width:100%;" name="fk_cat_id">
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->cat_id}}">{{$category->cat_name}}</option>
                                @endforeach   
                            </select>
                        </div>    
                    </div>
                    
                    <hr>
                    <div class="row" align="center" style="margin-bottom:20px;">
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
                <i class="fa fa-bar-chart-o fa-fw"></i> All Medicine
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped medsdatatables" style="table-layout:fixed" id="medstable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Medicine Name</th>
                                        <th >Formula</th>
                                        <th>Company Name</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($medicines as $medicine)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$medicine->med_name}}</td>
                                        <td style="word-wrap:break-word">{{$medicine->formula_name}}</td>
                                        <td>{{$medicine->company_name}}</td>
                                        <td>{{$medicine->cat_name}}</td>
                                        <td>
                                            <button onClick='deleteMedicine({{$medicine->med_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            {{-- <span>{{ $medicines->links() }}</span> --}}
                    </div>    
                </div>
            </div>
                <!-- /.panel-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> All Formulas
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
                                        <th>Formula Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($formulas as $formula)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$formula->formula_name}}</td>
                                        <td>
                                            <button onClick='deleteFormula({{$formula->formula_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
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

<!-- Stocks Modal -->
<div class="modal fade" id="deleteFormulaModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                   Do you really want to delete this Formula.
               </p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <form method="POST" action="{{ route('deleteformula')}}">
                @csrf
                <input hidden type="text" id="formulaidtodel" name="formula_id">
                <input class="btn btn-primary" type="submit" id="submit" value="Confirm">
                </form>
               {{-- <a class="btn btn-primary" href="{{route('deletecase' , Crypt::encrypt($case->case_id))}}">Confirm</a> --}}
           </div>
       </div>
   </div>
</div>
<!-- Stocks Modal -->

@endsection