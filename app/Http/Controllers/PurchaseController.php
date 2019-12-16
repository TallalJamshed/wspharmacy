<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\purchase_detail;
use App\sale_detail;
use App\p_recovery;
use App\recovery;
use App\medicine;
use App\stock;
use App\vendor;
use App\vendor_ledger;
use App\vendor_ledger_detail;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Validator;
use Session;
use Auth;
use Dompdf\Dompdf;

class PurchaseController extends Controller
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
        $medicines = medicine::join('companies','companies.company_id','=','medicines.fk_company_id')
                                ->join('categories','categories.cat_id','=','medicines.fk_cat_id')
                                ->get();
        $vendors = vendor::getVendors();
        return view("purchaseviews.add_purchase_form")->with('medicines',$medicines)->with('vendors',$vendors);
    }
    public function showPurchaseForm(){
        $purchases = purchase::join('vendors','vendors.vendor_id','purchases.fk_vendor_id')->groupBy('invoice_no')->orderBy('purchases.purchase_date','DESC')->get();
        return view('purchaseviews.show_purchases')->with('purchases',$purchases);
    }

    public function getbyinvoice(Request $request){
        $vendorledger = purchase::select('vendor_name', 'vendor_id', 'invoice_no','total_purchase_amount', 'vendor_ledger_id')
                        ->join('vendor_ledgers','vendor_ledgers.fk_vendor_id','purchases.fk_vendor_id')
                        ->join('vendors','purchases.fk_vendor_id','vendors.vendor_id')
                        ->where('invoice_no',$request->invoice)->first();
                        // print_r($ledger);
        if($vendorledger){
            $couriers = purchase::select('purchase_courier')->where('fk_vendor_id',$vendorledger->vendor_id)->get();
            $ledger_details = vendor_ledger_detail::where('fk_vendor_ledger_id',$vendorledger->vendor_ledger_id)->get();
            $remaining = $vendorledger->total_purchase_amount;
            $sumcourier = 0;
            foreach ($couriers as $courier) {
                $sumcourier += $courier->purchase_courier;
            }
            foreach ($ledger_details as $value) {
                $remaining -= $value->paid_amount;
                $remaining -= $value->discount;
                $sumcourier -= $value->vcourier_paid; 
            }
            
            
            $array = ['ledger'=>$vendorledger , 'remaining'=>$remaining , 'ledger_details'=>$ledger_details, 'courier'=>$sumcourier];
        }else{
            $array = null;
        }
        return $array;
    }

    public function getbyvendor(Request $request){
        // print_r($request);
        $vendorledger = vendor::select('invoice_no', 'vendor_id','vendor_name','total_purchase_amount', 'vendor_ledger_id')
                        ->join('purchases','purchases.fk_vendor_id','vendors.vendor_id')
                        ->join('vendor_ledgers','vendor_ledgers.fk_vendor_id','vendors.vendor_id')
                        ->where('vendor_id',$request->vendor_name)->first();
                        // print_r($ledger);
        if($vendorledger){
            $couriers = purchase::select('purchase_courier')->where('fk_vendor_id',$vendorledger->vendor_id)->get();

            $ledger_details = vendor_ledger_detail::where('fk_vendor_ledger_id',$vendorledger->vendor_ledger_id)->get();
            $remaining = $vendorledger->total_purchase_amount;
            $sumcourier = 0;
            foreach ($couriers as $courier) {
                $sumcourier += $courier->purchase_courier;
            }
            foreach ($ledger_details as $value) {
                $remaining -= $value->paid_amount;
                $remaining -= $value->discount;
                $sumcourier -= $value->vcourier_paid; 
            }
            
            $array = ['ledger'=>$vendorledger , 'remaining'=>$remaining , 'ledger_details'=>$ledger_details, 'courier'=>$sumcourier];
        }else{
            $array = null;
        }
        return $array;
    }

    public function store(PurchaseRequest $request)
    {
        // $invoice = purchase::where('invoice_no','=',$request->invoice_no)->first();
        // if(!$invoice){
            $purchase = new purchase;
            $purchase->fill($request->all());
            $purchase->purchase_date = date('Y-m-d');
            $purchase->purchase_agent = Auth::user()->name;
            $purchase->save();
            $purchase_id = purchase::orderBy('created_at', 'DESC')->select('purchase_id')->first();
            $id = $purchase_id->purchase_id;
        // }
        // else {
        //     $id = $invoice->purchase_id;
        // }

        foreach($request->fk_med_id as $key=>$value)
        {
            $purchase_detail = new purchase_detail;
            $stocks = new stock;

            $purchase_detail->fk_purchase_id = $id;
            $purchase_detail->fk_med_id = $request->fk_med_id[$key];
            $purchase_detail->unit_quantity = $request->pkt_quantity[$key];
            $purchase_detail->subunit_quantity = $request->quantity_per_pkt[$key];
            $purchase_detail->unit_price = $request->pkt_price[$key];
            $add = $request->pkt_price[$key] / $request->quantity_per_pkt[$key];
            $purchase_detail->subunit_price = $add;
            $purchase_detail->purchasedetail_date = date('Y-m-d');
            $purchase_detail->expiry = $request->expiry_date[$key];
            $purchase_detail->save();
            
            $stock = stock::where('fk_med_id','=',$request->fk_med_id[$key])->first();
            if($stock){
                $quantity = $request->pkt_quantity[$key] * $request->quantity_per_pkt[$key] + $stock->total_quantity;
                $added = stock::where('fk_med_id','=',$request->fk_med_id[$key])->update(['total_quantity'=>$quantity]);
            }
            else{
                $stocks->fk_med_id = $request->fk_med_id[$key];
                $stocks->total_quantity += $request->pkt_quantity[$key] * $request->quantity_per_pkt[$key];
                $stocks->save();
            }
            
        }
        $purchaseitems = purchase_detail::where('fk_purchase_id','=',$id)->select('unit_quantity','unit_price')->get();
        $total = 0;
        foreach ($purchaseitems as $key) {
            $total += $key->unit_quantity * $key->unit_price;
        }
        purchase::where('purchase_id','=',$id)->update(['total_price'=>$total]);

        $lastpurchase = purchase::where('purchase_id',$id)->first();
        vendor_Ledger::addinledger($lastpurchase);

        Session::flash('message', 'New Purchase is added'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }
    
    public function genpurchasereport(Request $request){
        // dd($request);
        $messages = [
            'start_date.present' => 'Start Date should be present.',
            'end_date.present' => 'End Date should be present.',
            'start_date.date' => 'Start Date should be in date formate.',
            'end_date.date' => 'End Date should be in date formate.',
            'end_date.after_or_equal' => 'End Date should be equal to or comes after Start Date.',
            'vendor_id.present' => 'Customer Id should be present.',
            'vendor_id.numeric' => 'Customer Id should be a number.',
            'vendor_id.exists' => 'Customer Id does not exist in database.', 
        ];
        $validator = Validator::make($request->all(), [
            'start_date' => 'present|date|nullable',
            'end_date' => 'present|date|nullable|after_or_equal:start_date',
            'vendor_id' => 'present|numeric|nullable|exists:vendors',
        ], $messages)->validate();

        if(!empty($request->start_date) && !empty($request->end_date) && !empty($request->vendor_id)){
            $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->where('fk_vendor_id',$request->vendor_id)->whereBetween('purchase_date',[$request->start_date,$request->end_date])->get();
        }
        elseif(!empty($request->start_date) && !empty($request->end_date)){
            $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->whereBetween('purchase_date',[$request->start_date,$request->end_date])->get();
        }
        elseif(!empty($request->vendor_id) && !empty($request->start_date)){
            $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->where('fk_vendor_id',$request->vendor_id)->whereBetween('purchase_date',[$request->start_date,date('Y-m-d')])->get();
        }
        elseif(!empty($request->vendor_id) && !empty($request->end_date)){
                $start = purchase::select('purchase_date')->MIN('purchase_date')->first();
                $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->where('fk_vendor_id',$request->vendor_id)->whereBetween('purchase_date',[$start->purchase_date,$request->end_date])->get();
        }
        elseif(!empty($request->start_date)){
                $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->whereBetween('purchase_date',[$request->start_date,date('Y-m-d')])->get();
        }
        elseif(!empty($request->end_date)){
                $start = purchase::min('purchase_date');
                $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->whereBetween('purchase_date',[$start,$request->end_date])->get();
        }
        elseif(!empty($request->vendor_id)){
            $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->where('fk_vendor_id',$request->vendor_id)->get();
        }
        else{
            $purchases = purchase::leftJoin('vendors','purchases.fk_vendor_id','vendors.vendor_id')->get();
        }

        if(!empty($request->start_date)){$start_date = $request->start_date;}
        else{$start_date = date('d-m-Y' , strtotime(purchase::min('purchase_date')));}
        // dd($start_date);
        if(!empty($request->end_date)){$end_date = $request->end_date;}
        else{$end_date = date('d-m-Y');}

        $view = 'reportviews.purchasereport';

        // return view($view)->with('sales',$sales)->with('start_date',date('d-m-Y' , strtotime($start_date)))->with('end_date',date('d-m-Y' , strtotime($end_date)));
        $this->makePDF($purchases , date('d-m-Y' , strtotime($start_date)) , date('d-m-Y' , strtotime($end_date)) , $view);
    }
    

    public function makePDF($purchases ,$start_date , $end_date , $view){
        $dompdf = new Dompdf();
        // $dompdf->loadHTML('<h1>Hello World!</h1>');
        
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $view = view($view)->with('purchases',$purchases)->with('start_date',$start_date)->with('end_date',$end_date);
        $dompdf->loadHtml($view);
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->set_option('DOMPDF_UNICODE_ENABLED', 'TRUE');
        $dompdf->render();
        // $dompdf->stream('download.pdf' , array('Attachment'=>0));
        return $dompdf->stream('Purchase Report'.' '.date('d-m-Y h:i:s A'),array('Attachment'=>1));
        // exit(0);
    }
    

    public function returnpurchaseview(Request $request)
    {
        return view('purchaseviews.returnpurchase');
    }

    public function getpurchasebyinvoice(Request $request){
        $purchase = purchase::join('purchase_details','purchase_details.fk_purchase_id','purchases.purchase_id')
                        ->join('medicines','purchase_details.fk_med_id','medicines.med_id')
                        ->join('vendors','vendors.vendor_id','purchases.fk_vendor_id')
                        // ->join('recoveries','recoveries.fk_sale_detail_id','sale_details.sale_detail_id')
                        ->where('invoice_no',$request->invoice)
                        ->get();
        $sale = sale_detail::join('purchase_details','purchase_details.fk_med_id','sale_details.fk_med_id')
                            ->join('purchases','purchase_details.fk_purchase_id','purchases.purchase_id')
                            ->join('vendors','vendors.vendor_id','purchases.fk_vendor_id')
                            ->where('invoice_no',$request->invoice)
                            ->get();
        $precoveries = p_recovery::get();
        $recoveries = recovery::get();
        $data = ['purchase'=>$purchase , 'recoveries'=>$recoveries ,'precoveries'=>$precoveries, 'sales'=>$sale];
        return $data;
    }

    public function deletepurchase(Request $request)
    {
        $flagdetail = false;

        $purchase_id = $request->purchase_id;
        $vendor_id = $request->vendor_id;
        $purchase_details = purchase_detail::where('fk_purchase_id',$purchase_id)->get();
        foreach ($purchase_details as $key => $value) {
            if($request->purchase_detail_id == null){
                $request->purchase_detail_id = array();
            }
            if (!in_array($value->purchase_detail_id , $request->purchase_detail_id)) {
                $id = $value->purchase_detail_id;
                $qty = $value->unit_quantity * $value->subunit_quantity;
                $unit = $value->unit_price;
    
                $returned = p_recovery::select('p_recovered_amount')->where('fk_purchase_detail_id',$value->purchase_detail_id)->get();
                foreach ($returned as $key1 => $value1) {
                    $qty -= $value1->p_recovered_amount;
                }
                $sale = sale_detail::select('quantity_sold')->where('fk_med_id',$value->fk_med_id)->get();
                foreach ($sale as $key1 => $value2) {
                    $qty -= $value2->quantity_sold;
                }
                $stock = stock::where('fk_med_id',$value->fk_med_id)->first();
                $finalqty = $stock->total_quantity - $qty;

                $vledger = vendor_ledger::where('fk_vendor_id',$vendor_id)->first();
                $total_vledger = $vledger->total_purchase_amount - ($unit*$qty);

                $recovery = new p_recovery;
                $recovery->fk_purchase_detail_id = $id;
                $recovery->p_recovered_amount = $qty;
                $recovery->p_unit_price = $unit;
                $recovery->p_recovery_date = date('Y-m-d');
                $recovery->save();
                $flagdetail = true;
                vendor_ledger::where('fk_vendor_id',$vendor_id)->update(['total_purchase_amount'=>$total_vledger]);
                stock::where('fk_med_id',$value->fk_med_id)->update(['total_quantity'=>$finalqty]);

            }
        }
        $rt_qty = $request->rt_qty;
        if($rt_qty){
        foreach ($rt_qty as $key => $value) {
            if($value != null){
                $id = $request->purchase_detail_id[$key];
                $qty = $value;
                $unit = $request->unit_price[$key];
                $med_id = $request->med_id[$key];
                // echo($id.':');
                // echo($qty.':');
                // echo($unit.':');
                // echo($med_id.':');

                $stock = stock::where('fk_med_id',$med_id)->first();
                $finalqty = $stock->total_quantity - $qty;

                $vledger = vendor_ledger::where('fk_vendor_id',$vendor_id)->first();
                $total_vledger = $vledger->total_purchase_amount - ($unit*$qty);

                $recovery = new p_recovery;
                $recovery->fk_purchase_detail_id = $id;
                $recovery->p_recovered_amount = $qty;
                $recovery->p_unit_price = $unit;
                $recovery->p_recovery_date = date('Y-m-d');
                $recovery->save();
                $flagdetail = true;
                vendor_ledger::where('fk_vendor_id',$vendor_id)->update(['total_purchase_amount'=>$total_vledger]);
                stock::where('fk_med_id',$med_id)->update(['total_quantity'=>$finalqty]);

            }
        }}
        if ($flagdetail) {
            Session::flash('message', 'Sale Return is Added'); 
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->back();
        }else{
            Session::flash('message', 'Sale Return is not Added'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->back();
        }
    }

    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        //
    }
}
