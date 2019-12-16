<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;
use DB;
use App\recovery;
use App\sale_detail;
use App\stock;
use App\medicine;
use App\formula;
use App\purchase;
use App\purchase_detail;
use App\sale_price;
use App\Customer;
use App\Customer_category;
use App\Ledger;
use App\Ledger_detail;
use App\Http\Requests\SalesRequest;
use App\Http\Requests\ReportRequest;
use Auth;
use Session;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
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
        $formulas = formula::get();
        $customers = customer::join('customer_categories','customer_categories.cust_cat_id','customers.fk_cust_cat_id')->get();
        $cust_cat = Customer_category::getCat();
        $medicines = medicine::join('companies','medicines.fk_company_id','=','companies.company_id')
                                ->join('categories','categories.cat_id','=','medicines.fk_cat_id')
                                ->join('stocks','stocks.fk_med_id','=','medicines.med_id')
                                // ->join('purchase_details','medicines.med_id','purchase_details.fk_med_id')
                                // ->join('sale_prices','sale_prices.fk_med_id','medicines.med_id')
                                ->groupBy('medicines.med_name')
                                // ->orderBy('purchase_details.created_at','ASC')
                                ->get()->toArray();
        // $purchases = purchase_detail::select(DB::raw('select avg("subunit_price")'))->groupBy('fk_med_id')->get();
    //    echo("<pre>");
        foreach ($medicines as $key => $value) {
            // print_r($value);
           $price = purchase_detail::where('fk_med_id',$value['med_id'])->orderBy('created_at','DESC')->first();
           $medicines[$key] += array('sale_price'=>$price->subunit_price) ;
           
        //    echo($price);
       }
    //    die();
        $medicines1 = collect($medicines);
        // dd($medicines1); 
        return view("saleviews.add_sale_form")->with('cust_cat',$cust_cat)->with('medicines',$medicines1)->with('formulas' , $formulas)->with('customers',$customers);
    }

    public function showSalesForm(){
        $sales = sale::join('customers','sales.fk_cust_id','customers.cust_id')->groupBy('sale_invoice')->orderBy('sales.sale_date','DESC')->get();
        return view("saleviews.show_sales")->with('sales' , $sales);
    }

    public function getbyinvoice(Request $request){
        $ledger = sale::select('cust_name','cust_id', 'sale_invoice','total_sales_amount', 'ledger_id')
                        ->join('ledgers','ledgers.fk_cust_id','sales.fk_cust_id')
                        ->join('customers','sales.fk_cust_id','customers.cust_id')
                        // ->join('sales','sales.fk_cust_id','customers.cust_id')
                        ->where('sale_invoice',$request->invoice)->first();
                        // print_r($ledger);
        if($ledger){
            $couriers = sale::select('courier_service')->where('fk_cust_id',$ledger->cust_id)->get();
            $ledger_details = ledger_detail::where('fk_ledger_id',$ledger->ledger_id)->get();
            $remaining = $ledger->total_sales_amount;
            $sumcourier = 0;
            foreach ($couriers as $courier) {
                $sumcourier += $courier->courier_service;
            }
            foreach ($ledger_details as $value) {
                $remaining -= $value->paid_amount;
                $remaining -= $value->discount;
                $sumcourier -= $value->courier_paid;
            }
           
            $array = ['ledger'=>$ledger , 'remaining'=>$remaining , 'ledger_details'=>$ledger_details, 'courier'=>$sumcourier];
        }else{
            $array = null;
        }
        return $array;
    }

    public function getbycust(Request $request){
        // print_r($request);
        $ledger = customer::select('sale_invoice','cust_id','cust_name','total_sales_amount', 'ledger_id')
                        ->join('sales','sales.fk_cust_id','customers.cust_id')
                        ->join('ledgers','ledgers.fk_cust_id','customers.cust_id')
                        // ->join('sales','sales.fk_cust_id','customers.cust_id')
                        ->where('cust_id',$request->cust_name)->first();
                        // print_r($ledger);
        if($ledger){
            $couriers = sale::select('courier_service')->where('fk_cust_id',$ledger->cust_id)->get();
            $ledger_details = ledger_detail::where('fk_ledger_id',$ledger->ledger_id)->get();
            $remaining = $ledger->total_sales_amount;
            $sumcourier = 0;
            foreach ($couriers as $courier) {
                $sumcourier += $courier->courier_service;
            }
            foreach ($ledger_details as $value) {
                $remaining -= $value->paid_amount;
                $remaining -= $value->discount;
                $sumcourier -= $value->courier_paid;
            }
            
            

            $array = ['ledger'=>$ledger , 'remaining'=>$remaining , 'ledger_details'=>$ledger_details , 'courier'=>$sumcourier];
            // print_r($array);
        }else{
            $array = null;
        }
        return $array;
    }

    public function store(SalesRequest $request)
    {
        // dd($request);
            $sales = new sale;
            $sales->fill($request->all());
            $sales->sale_agent = Auth::user()->name;
            $sales->sale_date = date('Y-m-d');
            $sales->save();
            $sale_id = sale::orderBy('created_at', 'DESC')->select('sale_id')->first();
            $id = $sale_id->sale_id;
            sale::where('sale_id','=',$id)->update(['sale_invoice'=>$id]);
            // $sales->sale_invoice = $id;
            // $sales->save();

        foreach($request->fk_med_id as $key=>$value)
        {
            $sale_details = new sale_detail;
            $stocks = new stock;

            $sale_details->fk_sale_id = $id;
            $sale_details->fk_med_id = $request->fk_med_id[$key];
            $sale_details->quantity_sold = $request->sale_quantity[$key];
            $sale_details->price = $request->total_price[$key];
            $sale_details->saledetail_date = date('Y-m-d');
            $sale_details->save();
            $stock = stock::where('fk_med_id','=',$request->fk_med_id[$key])->first();
            if($stock){
                $quantity =  $stock->total_quantity - $request->sale_quantity[$key];
                $added = stock::where('fk_med_id','=',$request->fk_med_id[$key])->update(['total_quantity'=>$quantity]);
            }  
        }
        $saleitems = sale_detail::where('fk_sale_id','=',$id)->select('price')->get();
        $total = 0;
        foreach ($saleitems as $key) {
            $total += $key->price;
        }
        sale::where('sale_id','=',$id)->update(['total_sale'=>$total]);

        $lastsale = sale::where('sale_id',$id)->first();
        ledger::addinledger($lastsale);

        Session::flash('message', 'New Sale is generated'); 
        Session::flash('alert-class', 'alert-success'); 
        return $this->gensaleinvoicebyid($id);
        // return redirect()->back();
    }
    public function gensaleinvoicebyid($id)
    {
        $thissale = sale::join('customers','customers.cust_id','sales.fk_cust_id')
                        ->where('sales.sale_invoice',$id)
                        ->first();
        $allsales = sale::
                            // where('sale_date','<',$thissale->sale_date)
                            where('sale_id','!=',$thissale->sale_id)
                            ->where('fk_cust_id',$thissale->fk_cust_id)
                           ->get();
        $salesum = 0;
        foreach ($allsales as $key => $value) {
            $salesum += $value->total_sale;
        }
        // dd($thissale , $salesum);

        // $cust_id = $sales->cust_id;
        // dd($cust_id);
        $paidamounts = ledger::select('paid_amount','discount','courier_paid')
                                ->join('ledger_details','ledgers.ledger_id','ledger_details.fk_ledger_id')
                                ->where('ledgers.fk_cust_id',$thissale->fk_cust_id)
                                ->get();
        $paid = 0;
        foreach ($paidamounts as $key => $value) {
             $paid += ($value->paid_amount + $value->discount + $value->courier_paid);
        }
        $sale_details = sale_detail::join('medicines','medicines.med_id','sale_details.fk_med_id')->where('fk_sale_id',$id)->get();
        $view = 'saleviews.sale_invoice';
        return view($view)->with('sales',$thissale)
                          ->with('sale_details',$sale_details)
                          ->with('sale_sum',$salesum)
                          ->with('paid',$paid);


    }

    public function gensaleinvoice(Request $id)
    {
        $thissale = sale::join('customers','customers.cust_id','sales.fk_cust_id')
                        ->where('sales.sale_invoice',$id->invoice_no)
                        ->first();
        $allsales = sale::
                            // where('sale_date','<',$thissale->sale_date)
                            where('sale_id','!=',$thissale->sale_id)
                            ->where('fk_cust_id',$thissale->fk_cust_id)
                           ->get();
        $salesum = 0;
        foreach ($allsales as $key => $value) {
            $salesum += $value->total_sale;
        }
        // dd($thissale , $salesum);

        // $cust_id = $sales->cust_id;
        // dd($cust_id);
        $paidamounts = ledger::select('paid_amount','discount','courier_paid')
                                ->join('ledger_details','ledgers.ledger_id','ledger_details.fk_ledger_id')
                                ->where('ledgers.fk_cust_id',$thissale->fk_cust_id)
                                ->get();
        $paid = 0;
        foreach ($paidamounts as $key => $value) {
             $paid += ($value->paid_amount + $value->discount + $value->courier_paid);
        }

        // dd($thissale , $salesum , $paid);

        // $remaining = ledger::select('remaining_amount')
        //                         ->join('ledger_details','ledgers.ledger_id','ledger_details.fk_ledger_id')
        //                         ->where('ledgers.fk_cust_id',$cust_id)
        //                         ->where('payment_date','<=',$sales->sale_date)
        //                         ->orderBy('ledger_details_id','DESC')
        //                         ->first();
        // dd($remaining);
            // if (empty($remaining->remaining_amount)) {
            //     $amount = ledger::select('total_sales_amount')->where('ledgers.fk_cust_id',$cust_id)->first();
            //     $data = $amount->total_sales_amount;
                // $total = 0;
            // }else{
            //     $data = $remaining->remaining_amount;
            //     // $total = $remaining->remaining_amount;
            // }
        $sale_details = sale_detail::join('medicines','medicines.med_id','sale_details.fk_med_id')->where('fk_sale_id',$id->invoice_no)->get();
        $view = 'saleviews.sale_invoice';
        return view($view)->with('sales',$thissale)
                          ->with('sale_details',$sale_details)
                          ->with('sale_sum',$salesum)
                          ->with('paid',$paid);
        // $view = view($view)->with('sales',$sales)->with('sale_details',$sale_details);
        // $this->makePDF($view);
        // dd($sales , $sale_details);
    }

    public function returnsalesview()
    {
        return view('saleviews.returnsales');
    }

    public function getsalebyinvoice(Request $request){
        // echo($request);
        $sales = sale::join('sale_details','sale_details.fk_sale_id','sales.sale_id')
                        ->join('medicines','sale_details.fk_med_id','medicines.med_id')
                        ->join('customers','customers.cust_id','sales.fk_cust_id')
                        // ->join('recoveries','recoveries.fk_sale_detail_id','sale_details.sale_detail_id')
                        ->where('sale_invoice',$request->invoice)
                        ->get();
        $recoveries = recovery::get();
        $data = ['sales'=>$sales , 'recoveries'=>$recoveries];
        return $data;
    }

    public function showsales($filter)
    {
        $dailysales = sale::select('sale_date', DB::raw('count(sale_date) as dailysales'))
                                ->groupBy('sale_date')
                                ->orderBy('sale_date','DESC')
                                ->take(30)->get();
        return $dailysales;
    }

    public function showDailySales()
    {
        $customers = customer::getCustomers();
        $dailysales = sale::orderBy('sale_date','DESC')->get();
        // dd($sales);
        return view('reportviews.daily_sales')->with('dailysales',$dailysales)->with('customers',$customers);
    }

    public function showTopSales()
    {
        $query = sale_detail::selectRaw('med_name , sum(quantity_sold) as quantity , sum(price) as saleprice')
                                ->join('medicines', 'medicines.med_id', 'sale_details.fk_med_id')
                                ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                ->groupBy('fk_med_id')
                                ->orderBy('quantity','DESC')
                                ->get();
        return view('reportviews.top_sales')->with('topsales' , $query);
    }

    public function gensalesreport(ReportRequest $request){
        if(!empty($request->start_date) && !empty($request->end_date) && !empty($request->cust_id)){
            $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->where('fk_cust_id',$request->cust_id)->whereBetween('sale_date',[$request->start_date,$request->end_date])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('sale_date',[$request->start_date,$request->end_date])
                                    ->get();
        }
        elseif(!empty($request->start_date) && !empty($request->end_date)){
            $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->whereBetween('sale_date',[$request->start_date,$request->end_date])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    // ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('sale_date',[$request->start_date,$request->end_date])
                                    ->get();
        }
        elseif(!empty($request->cust_id) && !empty($request->start_date)){
            $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->where('fk_cust_id',$request->cust_id)->whereBetween('sale_date',[$request->start_date,date('Y-m-d')])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('sale_date',[$request->start_date,date('Y-m-d')])
                                    ->get();
        }
        elseif(!empty($request->cust_id) && !empty($request->end_date)){
                $start = sale::select('sale_date')->MIN('sale_date')->first();
                $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->where('fk_cust_id',$request->cust_id)->whereBetween('sale_date',[$start->sale_date,$request->end_date])->get();
                $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('sale_date',[$start->sale_date,$request->end_date])
                                    ->get();
        }
        elseif(!empty($request->start_date)){
                $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->whereBetween('sale_date',[$request->start_date,date('Y-m-d')])->get();
                $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                        ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                        ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                        // ->where('sales.fk_cust_id',$request->cust_id)
                                        ->whereBetween('sale_date',[$request->start_date,date('Y-m-d')])
                                        ->get();
        }
        elseif(!empty($request->end_date)){
                $start = sale::min('sale_date');
                $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->whereBetween('sale_date',[$start,$request->end_date])->get();
                $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                        ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                        ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                        // ->where('sales.fk_cust_id',$request->cust_id)
                                        ->whereBetween('sale_date',[$start,$request->end_date])
                                        ->get();
            }
        elseif(!empty($request->cust_id)){
            $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->where('fk_cust_id',$request->cust_id)->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    // ->whereBetween('sale_date',[$start,$request->end_date])
                                    ->get();
        }
        else{
            $sales = sale::leftJoin('customers','sales.fk_cust_id','customers.cust_id')->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    // ->where('sales.fk_cust_id',$request->cust_id)
                                    // ->whereBetween('sale_date',[$start,$request->end_date])
                                    ->get();
        }

        if(!empty($request->start_date)){$start_date = $request->start_date;}
        else{$start_date = date('d-m-Y' , strtotime(sale::min('sale_date')));}
        // dd($start_date);
        if(!empty($request->end_date)){$end_date = $request->end_date;}
        else{$end_date = date('d-m-Y');}

        $view = 'reportviews.salesreport';

        // return view($view)->with('sales',$sales)->with('start_date',date('d-m-Y' , strtotime($start_date)))->with('end_date',date('d-m-Y' , strtotime($end_date)));
        $this->makePDF($sales ,$recovery, date('d-m-Y' , strtotime($start_date)) , date('d-m-Y' , strtotime($end_date)) , $view);
    }
    

    public function makePDF($sales,$recovery ,$start_date , $end_date , $view){
        $dompdf = new Dompdf();
        // $dompdf->loadHTML('<h1>Hello World!</h1>');
        
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $view = view($view)->with('sales',$sales)->with('recovery',$recovery)->with('start_date',$start_date)->with('end_date',$end_date);
        $dompdf->loadHtml($view);
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->set_option('DOMPDF_UNICODE_ENABLED', 'TRUE');
        $dompdf->render();
        // $dompdf->stream('download.pdf' , array('Attachment'=>0));
        return $dompdf->stream('Sales Report'.' '.date('d-m-Y h:i:s A'),array('Attachment'=>1));
        // exit(0);
    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function deletesales(Request $request)
    {
        $flagdetail = false;

        $sale_id = $request->sale_id;
        $cust_id = $request->cust_id;
        $sale_details = sale_detail::where('fk_sale_id',$sale_id)->get();
        foreach ($sale_details as $key => $value) {
            if($request->sale_detail_id == null){
                $request->sale_detail_id = array();
            }
            if (!in_array($value->sale_detail_id , $request->sale_detail_id)) {
                $id = $value->sale_detail_id;
                $qty = $value->quantity_sold;
                $unit = ($value->price / $value->quantity_sold);

                // $returned = p_recovery::select('p_recovered_amount')->where('fk_purchase_detail_id',$value->purchase_detail_id)->get();
                // foreach ($returned as $key1 => $value1) {
                //     $qty -= $value1->p_recovered_amount;
                // }

                $stock = stock::where('fk_med_id',$value->fk_med_id)->first();
                $finalqty = $stock->total_quantity + $qty;

                $ledger = ledger::where('fk_cust_id',$cust_id)->first();
                $total_ledger = $ledger->total_sales_amount - ($unit*$qty);

                $returned = recovery::select('recovered_amount')->where('fk_sale_detail_id',$value->sale_detail_id)->get();
                foreach ($returned as $key1 => $value1) {
                    $qty -= $value1->recovered_amount;
                }
                if($qty > 0 ){
                $recovery = new recovery;
                $recovery->fk_sale_detail_id = $id;
                $recovery->recovered_amount = $qty;
                $recovery->unit_price = $unit;
                $recovery->recovery_date = date('Y-m-d');
                $recovery->save();
                $flagdetail = true;
                ledger::where('fk_cust_id',$cust_id)->update(['total_sales_amount'=>$total_ledger]);
                stock::where('fk_med_id',$value->fk_med_id)->update(['total_quantity'=>$finalqty]);
                }

            }
        }
        $rt_qty = $request->rt_qty;
        if($rt_qty){
        foreach ($rt_qty as $key => $value) {
            if($value != null){
                $id = $request->sale_detail_id[$key];
                $qty = $value;
                $unit = $request->unit_price[$key];
                $med_id = $request->med_id[$key];
                // echo($id.':');
                // echo($qty.':');
                // echo($unit.':');
                // echo($med_id.':');

                $stock = stock::where('fk_med_id',$med_id)->first();
                $finalqty = $stock->total_quantity + $qty;

                $ledger = ledger::where('fk_cust_id',$cust_id)->first();
                $total_ledger = $ledger->total_sales_amount - ($unit*$qty);

                $recovery = new recovery;
                $recovery->fk_sale_detail_id = $id;
                $recovery->recovered_amount = $qty;
                $recovery->unit_price = $unit;
                $recovery->recovery_date = date('Y-m-d');
                $recovery->save();
                $flagdetail = true;
                ledger::where('fk_cust_id',$cust_id)->update(['total_sales_amount'=>$total_ledger]);
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

        // $sale_id = $request->sale_id;
        // $cust_id = $request->cust_id;
        // $sale_details = sale_detail::where('fk_sale_id',$sale_id)->get();
        // foreach ($sale_details as $value) {
        //     if (!in_array($value->sale_detail_id , $request->sale_detail_id)) {
        //         $qty = $value->quantity_sold;
        //         $prev_qty = stock::select('total_quantity')->where('fk_med_id',$value->fk_med_id)->first();
        //         $new_qty = $prev_qty->total_quantity + $qty;
        //         stock::where('fk_med_id',$value->fk_med_id)->update(['total_quantity'=>$new_qty]);

        //         $price = $value->price;
        //         $prev_price = sale::select('total_sale')->where('sale_id',$value->fk_sale_id)->first();
        //         $new_price = $prev_price->total_sale - $price;
        //         sale::where('sale_id',$value->fk_sale_id)->update(['total_sale'=>$new_price]);

        //         $prev_ledger = ledger::where('fk_cust_id',$cust_id)->first();
        //         $new_ledger_price = $prev_ledger->total_sales_amount - $price;
        //         ledger::where('fk_cust_id',$cust_id)->update(['total_sales_amount'=>$new_ledger_price]);

        //         $ledger_details = ledger_detail::where('fk_ledger_id',$prev_ledger->ledger_id)->orderBy('ledger_details_id','DESC')->first();
        //         // foreach ($ledger_details as $value) {
        //         //     $sum = $prev_ledger->total_sales_amount - $value->paid_amount;
        //         // }
        //             if($ledger_details){
        //         $ledger_detail = new ledger_detail;
        //         $ledger_detail->fk_ledger_id = $prev_ledger->ledger_id;
        //         $ledger_detail->total_amount = $ledger_details->remaining_amount;
        //         $ledger_detail->paid_amount = ($price * -1);
        //         $ledger_detail->remaining_amount = $ledger_details->remaining_amount;
        //         $ledger_detail->discount = 0;
        //         $ledger_detail->payment_date = date('Y-m-d');
        //         $ledger_detail->save();
        //             }

        //         sale_detail::destroy($value->sale_detail_id);
        //         $flagdetail = true;
        //         // echo('not found'.$value->sale_detail_id);
        //         // echo($qty);
        //         // echo($prev_qty);
        //         // echo($prev_ledger->total_sales_amount * -1);
        //     }
        // }
        //     $rt_qty = $request->rt_qty;
        //     // $rt_price = $request->rt_price;
        //     foreach ($rt_qty as $key => $value) {
        //         if($value != null){
        //             $id = $request->sale_detail_id[$key];
        //             $sale_details = sale_detail::where('sale_detail_id',$id)->first();
        //             $unit_price = $sale_details->price / $sale_details->quantity_sold;
        //             $final_qty = $sale_details->quantity_sold - $value;
        //             $final_price = $final_qty * $unit_price;
        //             $diff_price = $sale_details->price - $final_price;
        //             $sale_id = $sale_details->fk_sale_id;
        //             $fk_med_id = $sale_details->fk_med_id;
        //             $prev_stock = stock::select('total_quantity')->where('fk_med_id',$fk_med_id)->first();
        //             $new_stock = $prev_stock->total_quantity + $value;

        //             $sales = sale::where('sale_id',$sale_id)->first();
        //             $final_sale_price = $sales->total_sale - $diff_price;
                    
        //             $ledger = ledger::where('fk_cust_id',$sales->fk_cust_id)->first();
        //             $final_ledger_price = $ledger->total_sales_amount - $diff_price;

        //             $ledger_details = ledger_detail::where('fk_ledger_id',$ledger->ledger_id)->orderBy('ledger_details_id','DESC')->first();

        //             if($ledger_details){
        //             $ledger_detail = new ledger_detail;
        //             $ledger_detail->fk_ledger_id = $ledger->ledger_id;
        //             $ledger_detail->total_amount = $ledger_details->remaining_amount;
        //             $ledger_detail->paid_amount = ($diff_price * -1);
        //             $ledger_detail->remaining_amount = $ledger_details->remaining_amount;
        //             $ledger_detail->discount = 0;
        //             $ledger_detail->payment_date = date('Y-m-d');
        //             $ledger_detail->save();
        //             }

        //             ledger::where('fk_cust_id',$sales->fk_cust_id)->update(['total_sales_amount'=>$final_ledger_price]);
        //             sale::where('sale_id',$sale_id)->update(['total_sale'=>$final_sale_price]);
        //             sale_detail::where('sale_detail_id',$id)->update(['quantity_sold'=>$final_qty , 'price'=>$final_price]);
        //             stock::where('fk_med_id',$fk_med_id)->update(['total_quantity'=>$new_stock]);
        //             $flagdetail = true;
        //             // echo "value present";
        //             // echo ($unit_price.':');
        //             // echo ($final_qty.':');
        //             // echo ($final_price.':');
        //             // echo ($diff_price.':');
        //             // echo ($final_sale_price.':');
        //             // echo ($fk_med_id);
        //         }
        //     }
        // // if($flagdetail){
        // //     $sale_details = sale_detail::select('sale_detail_id')->where('fk_sale_id',$sale_id)->get();

        // // }
        // // die();
        // // dd($request);
        // if ($flagdetail) {
        //     Session::flash('message', 'Sale Return is Added'); 
        //     Session::flash('alert-class', 'alert-success'); 
        //     return redirect()->back();
        // }else{
        //     Session::flash('message', 'Sale Return is not Added'); 
        //     Session::flash('alert-class', 'alert-danger'); 
        //     return redirect()->back();
        // }

    }

    public function deleteinvoice(Request $request){
        dd($request->invoice_no);
    }
}
