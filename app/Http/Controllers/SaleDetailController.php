<?php

namespace App\Http\Controllers;

use App\Sale_detail;
use Illuminate\Http\Request;
use Session;

class SaleDetailController extends Controller
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
        //
    }

    // public function getavgpurchase(Request $request){
    //     // $last_sale = DB::select(DB::raw("select fk_med_id, avg(subunit_price) as avg_purchase from purchase_details where fk_med_id = '$request->fk_med_id'"));
    //     $last_sale = sale_detail::('')
    //     // print_r($purchases);
    //     return $purchases;
    // }

    public function store(Request $request)
    {
        //
    }

    public function getSaleMeds(Request $request)
    {
        $details = sale_detail::join('medicines','sale_details.fk_med_id','medicines.med_id')->where('fk_sale_id',$request->sale_id)->get();
        return $details;
    }

    public function edit(Sale_detail $sale_detail)
    {
        //
    }

    public function update(Request $request, Sale_detail $sale_detail)
    {
        //
    }

    public function destroy(Sale_detail $sale_detail)
    {
        //
    }
}
