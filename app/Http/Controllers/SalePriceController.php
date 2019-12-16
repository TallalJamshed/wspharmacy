<?php

namespace App\Http\Controllers;

use App\Sale_price;
use App\medicine;
use App\company;
use App\purchase_detail;
use App\stock;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\PriceSaveRequest;
use Illuminate\Support\Facades\Validator;

class SalePriceController extends Controller
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
        $medicines = stock::getMedsByStock();
        $pricings = Sale_price::getPricing();
        return view('createitemviews.add_pricing_form')->with('medicines',$medicines)->with('pricings',$pricings);
    }

    public function store(PriceSaveRequest $request)
    {
        $pricing = sale_price::storeData($request);
        Session::flash('message', 'New Pricing is added'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }

    public function show(Sale_price $sale_price)
    {
        //
    }

    public function edit(Sale_price $sale_price)
    {
        //
    }

    public function update(Request $request, Sale_price $sale_price)
    {
        //
    }

    public function destroy(Sale_price $sale_price)
    {
        //
    }
}
