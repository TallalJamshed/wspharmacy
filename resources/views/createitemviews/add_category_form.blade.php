@extends('layout.template')
@section('content')
{{-- @include('partials.cards') --}}

@if ($errors->has('cat_name'))
    <div class="invalid-feedback" >
        <strong class="errormsg">{{$errors->first('cat_name')}}</strong>
    </div>
@endif

<div class="row" >
    <div class="col-lg-12 pagetopmargin" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Add Category
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="{{route('addcategoriesindb')}}" method="post">
                    @csrf
                    <div class="row" align="center" style="margin-top:10px">
                        <div class="col-md-2">
                            <label for="validationServer01">Category Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" required name="cat_name" class="form-control is-valid" id="validationServer01" placeholder="Enter Category Name"  >
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
                <i class="fa fa-bar-chart-o fa-fw"></i> All Categories
            </div>
                <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-striped alldatatables" style="table-layout:fixed" id="categorytable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Categry Name</th>
                                        <th style="width:100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:white; ">
                                    <?php $serial = 1; ?>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$category->cat_name}}</td>
                                        <td>
                                            <button onClick='deleteCategory({{$category->cat_id}})' class="btn btn-md btn-danger"><i style="color:white" class="fa fa-trash-o"></i></button>
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
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-hidden="true"
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
                   Do you really want to delete this Category.
               </p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <form method="POST" action="{{ route('deletecategory')}}">
                @csrf
                <input hidden type="text" id="categoryidtodel" name="cat_id">
                <input class="btn btn-primary" type="submit" id="submit" value="Confirm">
                </form>
               {{-- <a class="btn btn-primary" href="{{route('deletecase' , Crypt::encrypt($case->case_id))}}">Confirm</a> --}}
           </div>
       </div>
   </div>
</div>
<!-- Stocks Modal -->

    
@endsection