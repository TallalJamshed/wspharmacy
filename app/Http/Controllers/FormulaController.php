<?php

namespace App\Http\Controllers;

use App\Formula;
use Illuminate\Http\Request;
use App\Http\Requests\FormulaSaveRequest;
use Illuminate\Support\Facades\Validator;
use Session;

class FormulaController extends Controller
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
        $formulas = formula::getFormula();
        return view('createitemviews.add_formula_form')->with('formulas',$formulas);
    }

    public function store(FormulaSaveRequest $request)
    {
        formula::storeData($request);
        Session::flash('message', 'New Formula is added'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }

    public function show(Formula $formula)
    {
        //
    }

    public function edit(Formula $formula)
    {
        //
    }

    public function update(Request $request, Formula $formula)
    {
        //
    }

    public function destroy(Request $request)
    {
        if(isset($request->formula_id)){
            formula::deleteData($request);
        }
        Session::flash('message', 'Formula is deleted'); 
        Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back();
    }
}
