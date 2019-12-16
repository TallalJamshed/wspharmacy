<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CatSaveRequest;
use Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }

    public function create()
    {
        $categories = category::getCat();
        return view('createitemviews.add_category_form')->with('categories',$categories);
    }

    public function store(CatSaveRequest $request)
    {
        category::storeData($request);
        Session::flash('message', 'New Category is added'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Request $request)
    {
        if(isset($request->cat_id))
        {
            category::deleteData($request);
        }
        Session::flash('message', 'Category is deleted'); 
        Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back();
    }
}
