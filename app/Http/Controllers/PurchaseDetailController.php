<?php

namespace App\Http\Controllers;

use App\Purchase_detail;
use App\purchase;
use App\medicine;
use App\expiry;
use App\sale_detail;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

class PurchaseDetailController extends Controller
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
        $purchases = purchase::orderBy('created_at', 'DESC')->get();
        $medicines = medicine::join('companies','companies.company_id','=','medicines.fk_company_id')
                                ->join('categories','categories.cat_id','=','medicines.fk_cat_id')
                                ->get();
        return view('purchaseviews.add_stocks_form')->with('purchases',$purchases)->with('medicines',$medicines);
    }

    public function store(Request $request)
    {
        $purchase_detail = new purchase_detail;
        $purchase_detail->fill($request->all());
        $purchase_detail->save();
        return redirect()->back();
    }

    public function show(Purchase_detail $purchase_detail)
    {
        //
    }
    
    public function getExpiredMeds(){
        $expiredmeds = purchase_detail::join('medicines','purchase_details.fk_med_id','medicines.med_id')
                                ->where('expiry','<',date('Y-m-d'))
                                ->where('expiry_shown',0)
                                ->select('med_name','expiry')
                                ->get();
        return view('reportviews.expired_meds')->with('expiredmeds',$expiredmeds);
    }

    public function getlastpurchase(Request $request){
        // echo($request->med_id);
        return purchase_detail::where('fk_med_id',$request->fk_med_id)->orderBy('created_at','DESC')->first();
    }

    public function getMeds(Request $request)
    {
        $details = purchase_detail::join('medicines','purchase_details.fk_med_id','medicines.med_id')->where('fk_purchase_id',$request->purchase_id)->get();
        return $details;
    }

    public function deletePurchase(Request $request){
        $meds = purchase::select('fk_med_id','purchasedetail_date')->join('purchase_details','purchases.purchase_id','purchase_details.fk_purchase_id')
                            ->where('purchase_id',$request->purchase_id)
                            ->get();
        $sold = false;
        foreach($meds as $key){
            $data = sale_detail::where('fk_med_id',$key->fk_med_id)
                                ->where('saledetail_date','>',$key->purchasedetail_date)
                                ->orderBy('saledetail_date','DESC')
                                ->first();
            if($data){
                $sold = true;
            }
        }
        if($sold){
            Session::flash('message', 'Some Medicines are already sold'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->back();
        }

    }

    public function update(Request $request, Purchase_detail $purchase_detail)
    {
        //
    }

    public function destroy(Purchase_detail $purchase_detail)
    {
        //
    }
}
