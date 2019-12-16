<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Recovery;
use App\p_recovery;
use App\purchase;
use App\purchase_detail;
use App\sale_detail;
use App\stock;
use App\customer;
use App\vendor;
use App\medicine;
use App\ledger_detail;
use App\vendor_ledger_detail;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;
use Dompdf\Dompdf;
use Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function create()
    {   $expiries = purchase_detail::select('purchase_detail_id','expiry')->where('expiry','<',date('Y-m-d'))->where('expiry_shown',0)->get();
        // dd($expiries->first());
        if($expiries->first()){
            foreach ($expiries as $key) {
                $date = strtotime($key->expiry);
                if(date('d-m-Y') >= date('d-m-Y' ,strtotime("+7 days",$date)) ){
                    purchase_detail::where('purchase_detail_id',$key->purchase_detail_id)->update(['expiry_shown'=>1]);
                }
            }
        }
        $sales = sale::count();
        $stocks = stock::join('medicines','stocks.fk_med_id','=','medicines.med_id')->join('companies','medicines.fk_company_id','=','companies.company_id')->join('categories','categories.cat_id','=','medicines.fk_cat_id')->join('purchase_details','purchase_details.fk_med_id','=','medicines.med_id')->join('purchases','purchase_details.fk_purchase_id','=','purchases.purchase_id')->groupBy('medicines.med_id')->get();
        return view("dashboard")->with('stocks',$stocks)->with('sales',$sales);
    }

    public function genreport()
    {
        $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('sales.fk_cust_id')->get();
        $vendors = vendor::join('purchases','purchases.fk_vendor_id','vendors.vendor_id')->groupBy('purchases.fk_vendor_id')->get();
        return view('reportviews.genreportview')->with('customers',$customers)->with('vendors',$vendors);
    }
    public function genplreport()
    {
        return view('reportviews.plreportview');
    }
    public function recoveryreport()
    {
        $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('sales.fk_cust_id')->get();
        // $vendors = vendor::join('purchases','purchases.fk_vendor_id','vendors.vendor_id')->groupBy('purchases.fk_vendor_id')->get();
        return view('reportviews.recoveryreportview')->with('customers',$customers);
    }

    public function genplreportdata(Request $request){
        // dd($request);
        // if(!empty($request->start_date) && !empty($request->end_date) && !empty($request->cust_id)){
        //     $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->where('cust_id',$request->cust_id)->whereBetween('sales.created_at',[$request->start_date,$request->end_date])->get();
        //     $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->whereBetween('sales.created_at',[$request->start_date,$request->end_date])->get();
        //     $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->whereBetween('ledgers.created_at',[$request->start_date,$request->end_date])->get();
        // } 
        // else
        if(!empty($request->start_date) && !empty($request->end_date)){
            $medicines = medicine::join('sale_details','sale_details.fk_med_id','medicines.med_id')->groupBy('fk_med_id')->whereBetween('sale_details.saledetail_date',[$request->start_date,$request->end_date])->get();
            $purchases = purchase_detail::join('medicines','purchase_details.fk_med_id','medicines.med_id')->join('purchases','purchase_details.fk_purchase_id','purchases.purchase_id')->whereBetween('purchase_details.purchasedetail_date',[$request->start_date,$request->end_date])->get();
            $sales = sale_detail::join('medicines','sale_details.fk_med_id','medicines.med_id')->join('sales','sale_details.fk_sale_id','sales.sale_id')->whereBetween('sales.sale_date',[$request->start_date,$request->end_date])->get();
            $sale_couriers = Sale::select('courier_service')->whereBetween('sale_date',[$request->start_date,$request->end_date])->get();
            $purchase_couriers = purchase::select('purchase_courier')->whereBetween('purchase_date',[$request->start_date,$request->end_date])->get();
            $paidsalecourier = ledger_detail::select('courier_paid')->whereBetween('payment_date',[$request->start_date,$request->end_date])->get();
            $paidprccourier = vendor_ledger_detail::select('vcourier_paid')->whereBetween('payment_date',[$request->start_date,$request->end_date])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    // ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('sales.sale_date',[$request->start_date,$request->end_date])
                                    ->get();
        }
        elseif(!empty($request->start_date)){
            $medicines = medicine::join('sale_details','sale_details.fk_med_id','medicines.med_id')->groupBy('fk_med_id')->whereBetween('sale_details.saledetail_date',[$request->start_date,date('Y-m-d')])->get();
            $purchases = purchase_detail::join('medicines','purchase_details.fk_med_id','medicines.med_id')->join('purchases','purchase_details.fk_purchase_id','purchases.purchase_id')->whereBetween('purchase_details.purchasedetail_date',[$request->start_date,date('Y-m-d')])->get();
            $sales = sale_detail::join('medicines','sale_details.fk_med_id','medicines.med_id')->join('sales','sale_details.fk_sale_id','sales.sale_id')->whereBetween('sales.sale_date',[$request->start_date,date('Y-m-d')])->get();
            $sale_couriers = Sale::select('courier_service')->whereBetween('sales.sale_date',[$request->start_date,date('Y-m-d')])->get();
            $purchase_couriers = purchase::select('purchase_courier')->whereBetween('purchase_date',[$request->start_date,date('Y-m-d')])->get();
            $paidsalecourier = ledger_detail::select('courier_paid')->whereBetween('payment_date',[$request->start_date,date('Y-m-d')])->get();
            $paidprccourier = vendor_ledger_detail::select('vcourier_paid')->whereBetween('payment_date',[$request->start_date,date('Y-m-d')])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                        ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                        ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                        // ->where('sales.fk_cust_id',$request->cust_id)
                                        ->whereBetween('sales.sale_date',[$request->start_date,date('Y-m-d')])
                                        ->get();
        }
        elseif(!empty($request->end_date)){
            // dd(date('Y-m-d',strtotime($request->end_date)));
            // $start = sale::select('sale_date')->MIN('sale_date')->first();
            $medicines = medicine::join('sale_details','sale_details.fk_med_id','medicines.med_id')->groupBy('fk_med_id')->where('sale_details.saledetail_date','<=',$request->end_date)->get();
            $purchases = purchase_detail::join('medicines','purchase_details.fk_med_id','medicines.med_id')->join('purchases','purchase_details.fk_purchase_id','purchases.purchase_id')->where('purchase_details.purchasedetail_date','<=',$request->end_date)->get();
            $sales = sale_detail::join('medicines','sale_details.fk_med_id','medicines.med_id')->join('sales','sale_details.fk_sale_id','sales.sale_id')->where('sales.sale_date','<=',$request->end_date)->get();
            $sale_couriers = Sale::select('courier_service')->where('sales.sale_date','<=',$request->end_date)->get();
            $purchase_couriers = purchase::select('purchase_courier')->where('purchase_date','<=',$request->end_date)->get();
            $paidsalecourier = ledger_detail::select('courier_paid')->where('payment_date','<=',$request->end_date)->get();
            $paidprccourier = vendor_ledger_detail::select('vcourier_paid')->where('payment_date','<=',$request->end_date)->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                        ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                        ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                        // ->where('sales.fk_cust_id',$request->cust_id)
                                        ->where('sales.sale_date','<=',$request->end_date)
                                        ->get();
        }
        else{
            $medicines = medicine::join('sale_details','sale_details.fk_med_id','medicines.med_id')->groupBy('fk_med_id')->get();
            $purchases = purchase_detail::join('medicines','purchase_details.fk_med_id','medicines.med_id')->join('purchases','purchase_details.fk_purchase_id','purchases.purchase_id')->get();
            $sales = sale_detail::join('medicines','sale_details.fk_med_id','medicines.med_id')->join('sales','sale_details.fk_sale_id','sales.sale_id')->get();
            $sale_couriers = Sale::select('courier_service')->get();
            $purchase_couriers = purchase::select('purchase_courier')->get();
            $paidsalecourier = ledger_detail::select('courier_paid')->get();
            $paidprccourier = vendor_ledger_detail::select('vcourier_paid')->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                        ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                        ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                        // ->where('sales.fk_cust_id',$request->cust_id)
                                        // ->whereBetween('sales.sale_date','<=',$request->end_date)
                                        ->get();
        }

        if(!empty($request->start_date)){
            $start_date = $request->start_date;
        }else{
            $start_date = date('d-m-Y' , strtotime(sale::min('sale_date')));
        }
        if(!empty($request->end_date)){
            $end_date = $request->end_date;
        }else{
            $end_date = date('d-m-Y');
        }

        $view = 'reportviews.plreport';
        
        
        // return view($view)->with('medicines',$medicines)
        //                   ->with('purchases',$purchases)
        //                   ->with('sales',$sales)
        //                   ->with('couriers',$couriers)
        //                   ->with('purchase_couriers',$purchase_couriers)
        //                   ->with('start_date',date('d-m-Y' , strtotime($start_date)))
        //                   ->with('end_date',date('d-m-Y' , strtotime($end_date)));
        $this->makePDF($medicines,$purchases,$sales,$sale_couriers,$purchase_couriers,$recovery,$paidsalecourier,$paidprccourier , date('d-m-Y' , strtotime($start_date)) , date('d-m-Y' , strtotime($end_date)) , $view);

    }

    public function makePDF($medicines,$purchases,$sales,$sale_couriers,$purchase_couriers,$recovery,$paidsalecourier,$paidprccourier ,$start_date , $end_date , $view){
        $dompdf = new Dompdf();        
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $view = view($view)->with('medicines',$medicines)
                            ->with('purchases',$purchases)
                            ->with('sales',$sales)
                            ->with('sale_couriers',$sale_couriers)
                            ->with('purchase_couriers',$purchase_couriers)
                            ->with('recovery',$recovery)
                            ->with('paidsalecourier',$paidsalecourier)
                            ->with('paidprccourier',$paidprccourier)
                            // ->with('precovery',$precovery)
                            ->with('start_date',$start_date)
                            ->with('end_date',$end_date);
        $dompdf->loadHtml($view);
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->set_option('DOMPDF_UNICODE_ENABLED', 'TRUE');
        $dompdf->render();
        return $dompdf->stream('Profit_Loss Report'.' '.date('d-m-Y h:i:s A'),array('Attachment'=>1));
    }
    
}
