<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;
use App\sale;
use App\purchase_detail;
use Session;
use Auth;
use DB;
use Dompdf\Dompdf;


class StockController extends Controller
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
        // $stocks = DB::select('select MIN(expiry) as expiry from purchase_details group by fk_med_id');
        // dd($stocks);
        $expiry = DB::select('select MIN(expiry) as expiry , fk_med_id from purchase_details group by fk_med_id');
        // dd($expiry);
        $stocks = stock::join('medicines','stocks.fk_med_id','=','medicines.med_id')
                            ->join('companies','medicines.fk_company_id','=','companies.company_id')
                            ->join('categories','categories.cat_id','=','medicines.fk_cat_id')
                            ->join('purchase_details','purchase_details.fk_med_id','=','medicines.med_id')
                            ->join('purchases','purchase_details.fk_purchase_id','=','purchases.purchase_id')
                            ->groupBy('medicines.med_id')
                            ->get();
        return view("show_stocks")->with('stocks',$stocks)->with('expiry',$expiry);
    }
    public function printstocks (){
        $stocks = stock::select('med_name')->join('medicines','medicines.med_id','stocks.fk_med_id')->where('total_quantity','>',0)->orderBy('med_name')->get();
        // return view('stockprintview')->with('stocks',$stocks);
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $view = view('stockprintview')->with('stocks',$stocks);
        $dompdf->loadHtml($view);
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->set_option('DOMPDF_UNICODE_ENABLED', 'TRUE');
        $dompdf->render();
        return $dompdf->stream('Stock Report'.' '.date('d-m-Y h:i:s A'),array('Attachment'=>1));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Stock $stock)
    {
        //
    }

    public function edit(Stock $stock)
    {
        //
    }

    public function update(Request $request, Stock $stock)
    {
        //
    }

    public function destroy(Request $request)
    {
        if(isset($request->stock_id)){
            stock::where('stock_id',$request->stock_id)->delete();
        }
        Session::flash('message', 'Stock is destroyed'); 
        Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back();
    }
}
