<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\company;
use App\category;
use App\formula;
use Illuminate\Http\Request;
use App\Http\Requests\MedSaveRequest;
use Illuminate\Support\Facades\Validator;
use Session;

class MedicineController extends Controller
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
        $companies = company::getCompany();
        $formulas = formula::getFormula();
        $medicines = medicine::getMedicine();
        // dd($categories);
        return view('createitemviews.add_medicine_form')->with('companies',$companies)->with('medicines',$medicines)->with('categories',$categories)->with('formulas' , $formulas);
    }

    public function store(MedSaveRequest $request)
    {
        $medicine = medicine::storeData($request);
        Session::flash('message', 'New Medicine is added'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }

    public function show(Medicine $medicine)
    {
        //
    }

    public function edit(Medicine $medicine)
    {
        //
    }

    public function update(Request $request, Medicine $medicine)
    {
        //
    }

    public function destroy(Request $request)
    {
        if(isset($request->med_id)){
            medicine::deleteData($request->med_id);
        }
        Session::flash('message', 'Medicine is deleted'); 
        Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back();
    }

    public function getMedsByFormula($id){
        $data = medicine::where('fk_formula_id',$id)->get();
        return json_encode($data);
    }
}
