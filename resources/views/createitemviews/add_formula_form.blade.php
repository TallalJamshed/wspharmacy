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
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Formula
            </div>
                <!-- /.panel-heading -->
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