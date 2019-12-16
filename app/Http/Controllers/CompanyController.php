<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompSaveRequest;
use Illuminate\Support\Facades\Validator;
use Session;

class CompanyController extends Controller
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
        $companies = company::getCompany();
        return view('createitemviews.add_company_form')->with('companies',$companies);
    }

    public function store(CompSaveRequest $request)
    {
        company::storeData($request);
        Session::flash('message', 'New Company is added'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }

    public function show(Company $company)
    {
        //
    }

    public function edit(Company $company)
    {
        //
    }

    public function update(Request $request, Company $company)
    {
        //
    }

    public function destroy(Request $request)
    {
        if(isset($request->company_id)){
            company::deleteData($request);
        }
        Session::flash('message', 'Company is deleted'); 
        Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back();
    }
}
