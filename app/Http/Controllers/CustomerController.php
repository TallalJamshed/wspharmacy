<?php

namespace App\Http\Controllers;

use App\Customer;
use App\sale;
use App\ledger;
use App\recovery;
use App\Customer_category;
use Illuminate\Http\Request;
use App\Http\Requests\CustSaveRequest;
use App\Http\Requests\ReportRequest;
use Dompdf\Dompdf;


use Session;

class CustomerController extends Controller
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
        $customers = Customer::getCustomers();
        $cust_cat = Customer_category::getCat();
        return view('createitemviews.add_cust_form')->with('customers',$customers)->with('cust_cat',$cust_cat);
    }

    public function store(CustSaveRequest $request)
    {
        Customer::saveData($request);
        Session::flash('message', 'Customer is added'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }

    public function genrecoveryreport(ReportRequest $request){

        if(!empty($request->start_date) && !empty($request->end_date) && !empty($request->cust_id)){
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->where('cust_id',$request->cust_id)->whereBetween('sales.sale_date',[$request->start_date,$request->end_date])->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->where('cust_id',$request->cust_id)->whereBetween('sales.sale_date',[$request->start_date,$request->end_date])->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->where('cust_id',$request->cust_id)->whereBetween('ledger_details.payment_date',[$request->start_date,$request->end_date])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('recovery_date',[$request->start_date,$request->end_date])
                                    ->get();
        } 
        elseif(!empty($request->start_date) && !empty($request->end_date)){
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->whereBetween('sales.sale_date',[$request->start_date,$request->end_date])->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->whereBetween('sales.sale_date',[$request->start_date,$request->end_date])->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->whereBetween('ledger_details.payment_date',[$request->start_date,$request->end_date])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    // ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('recovery_date',[$request->start_date,$request->end_date])
                                    ->get();
        }
        elseif(!empty($request->cust_id) && !empty($request->start_date)){
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->where('cust_id',$request->cust_id)->whereBetween('sales.sale_date',[$request->start_date,date('Y-m-d')])->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->where('cust_id',$request->cust_id)->whereBetween('sales.sale_date',[$request->start_date,date('Y-m-d')])->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->where('cust_id',$request->cust_id)->whereBetween('ledger_details.payment_date',[$request->start_date,date('Y-m-d')])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('recovery_date',[$request->start_date,date('Y-m-d')])
                                    ->get();
        }
        elseif(!empty($request->cust_id) && !empty($request->end_date)){
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->where('cust_id',$request->cust_id)->where('sales.sale_date','<=',$request->end_date)->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->where('cust_id',$request->cust_id)->where('sales.sale_date','<=',$request->end_date)->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->where('cust_id',$request->cust_id)->where('ledger_details.payment_date','<=',$request->end_date)->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    ->where('recovery_date','<=',$request->end_date)
                                    ->get();

        }
        elseif(!empty($request->start_date)){
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->whereBetween('sales.sale_date',[$request->start_date,date('Y-m-d')])->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->whereBetween('sales.sale_date',[$request->start_date,date('Y-m-d')])->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->whereBetween('ledger_details.payment_date',[$request->start_date,date('Y-m-d')])->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    // ->where('sales.fk_cust_id',$request->cust_id)
                                    ->whereBetween('recovery_date',[$request->start_date,date('Y-m-d')])
                                    ->get();
        }
        elseif(!empty($request->end_date)){
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->where('sales.sale_date','<=',$request->end_date)->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->where('sales.sale_date','<=',$request->end_date)->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->where('ledger_details.payment_date','<=',$request->end_date)->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    // ->where('sales.fk_cust_id',$request->cust_id)
                                    ->where('recovery_date','<=',$request->end_date)
                                    ->get();
        }
        elseif(!empty($request->cust_id)){
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->where('cust_id',$request->cust_id)->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->where('cust_id',$request->cust_id)->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->where('cust_id',$request->cust_id)->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->where('sales.fk_cust_id',$request->cust_id)
                                    // ->where('sales.sale_date','<=',date('Y-m-d'))
                                    ->get();
        }
        else{
            $customers = customer::join('sales','sales.fk_cust_id','customers.cust_id')->groupBy('fk_cust_id')->get();
            $sales = sale::join('customers','customers.cust_id','sales.fk_cust_id')->get();
            $ledgers = ledger::join('customers','ledgers.fk_cust_id','customers.cust_id')->join('ledger_details','ledger_details.fk_ledger_id','ledgers.ledger_id')->get();
            $recovery = recovery::join('sale_details','sale_details.sale_detail_id','recoveries.fk_sale_detail_id')
                                    ->join('sales','sales.sale_id','sale_details.fk_sale_id')
                                    ->join('medicines','medicines.med_id','sale_details.fk_med_id')
                                    ->join('customers','customers.cust_id','sales.fk_cust_id')
                                    // ->where('sales.fk_cust_id',$request->cust_id)
                                    // ->where('sales.sale_date','<=',date('Y-m-d'))
                                    ->get();
                                    // dd($recovery);
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

        $view = 'reportviews.recoveryreport';

        // return view($view)->with('customers',$customers)
        //                   ->with('sales',$sales)
        //                   ->with('ledgers',$ledgers)
        //                   ->with('recovery',$recovery)
        //                   ->with('start_date',date('d-m-Y' , strtotime($start_date)))
        //                   ->with('end_date',date('d-m-Y' , strtotime($end_date)));
        $this->makePDF($customers,$sales,$ledgers,$recovery , date('d-m-Y' , strtotime($start_date)) , date('d-m-Y' , strtotime($end_date)) , $view);

    }

    public function makePDF($customers,$sales,$ledgers,$recovery ,$start_date , $end_date , $view){
        $dompdf = new Dompdf();        
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $view = view($view)->with('customers',$customers)
                           ->with('sales',$sales)
                           ->with('ledgers',$ledgers)
                           ->with('recovery',$recovery)
                           ->with('start_date',$start_date)
                           ->with('end_date',$end_date);
        $dompdf->loadHtml($view);
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->set_option('DOMPDF_UNICODE_ENABLED', 'TRUE');
        $dompdf->render();
        return $dompdf->stream('Recovery Report'.' '.date('d-m-Y h:i:s A'),array('Attachment'=>1));
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit(Customer $customer)
    {
        //
    }

    public function update(Request $request, Customer $customer)
    {
        //
    }

    public function destroy(Request $request)
    {
        if(isset($request->cust_id)){
            Customer::deleteData($request);
        }
        Session::flash('message', 'Customer is deleted'); 
        Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back();
    }
}
