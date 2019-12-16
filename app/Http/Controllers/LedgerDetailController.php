<?php

namespace App\Http\Controllers;

use App\Ledger_detail;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\paysaverequest;

class LedgerDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(paysaverequest $request)
    {
        // dd($request);
        $ledger_detail = new Ledger_detail;
        $remaining = $request->total_bill - $request->payment;
        
        // $ledger_detail->fill($request)
        $ledger_detail->fk_ledger_id = $request->ledger_id;
        $ledger_detail->total_amount = $request->total_bill;
        $ledger_detail->paid_amount = $request->payment;
        $ledger_detail->remaining_amount = $remaining;
        $ledger_detail->payment_date = date('Y-m-d');
        $ledger_detail->discount = $request->discount;
        $ledger_detail->courier_paid = $request->courier_paid;
        // dd($request);
        $ledger_detail->save();
        Session::flash('message', 'New Payment is added'); 
        Session::flash('alert-class', 'alert-success'); 
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ledger_detail  $ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger_detail $ledger_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ledger_detail  $ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger_detail $ledger_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ledger_detail  $ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ledger_detail $ledger_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ledger_detail  $ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger_detail $ledger_detail)
    {
        //
    }
}
