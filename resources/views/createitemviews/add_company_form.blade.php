@extends('layout.template')
@section('content')
{{-- @include('partials.cards') --}}

@if ($errors->has('company_name'))
    <div class="invalid-feedback" >
        <strong class="errormsg">{{$errors->first('company_name')}}</strong>
    </div>
@endif
<div class="row">
    <div class="col-lg-12 pagetopmargin">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Company
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="{{route('addcompanyindb')}}" method="post">
                    @csrf
                    <div class="row" align="center" style="margin-top:10px">
                        <div class="col-md-2">
                            <label for="validationServer01">Company Name</label>
                        </div>
                        <div class="col-md-8">
                            {{-- <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Enter Company Name"  required> --}}
                            {{-- Select if company already exists
                            <select class="js-example-basic-single form-control inputmargins" style="width:100%;" name="state">
                                <option></option>
                                @foreach ($companies as $company)
                                    <option name="{{$company->company_id}}" value="{{$company->company_name}}">{{$company->company_name}}</option>
                                @endforeach
                                
                            </select> --}}
                            {{-- OR Add New --}}
                            <input type="text" required name="company_name" class="form-control is-valid" id="validationServer01" placeholder="Enter Company Name"  >
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
                <i class="fa fa-bar-chart-o fa-fw"></i> All Companies
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="companytable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:150px">Serial Number</th>
                                        <th>Company Name</th>
                                        <th style="width:150px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($companies as $company)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$company->company_name}}</td>
                                        <td>
                                            <button onClick='deleteCompany({{$company->company_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
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
 <div class="modal fade" id="deleteCompanyModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                    Do you really want to delete this Company.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('deletecompany')}}">
                 @csrf
                 <input hidden type="text" id="companyidtodel" name="company_id">
                 <input class="btn btn-primary" type="submit" id="submit" value="Confirm">
                 </form>
                {{-- <a class="btn btn-primary" href="{{route('deletecase' , Crypt::encrypt($case->case_id))}}">Confirm</a> --}}
            </div>
        </div>
    </div>
 </div>
 <!-- Stocks Modal -->


    
@endsection