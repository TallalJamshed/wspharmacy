<?php

namespace App\Http\Controllers;

use App\vendor_ledger_detail;
use Illuminate\Http\Request;
use Session;

class VendorLedgerDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request)
    {
        // dd($request);
        $ledger_detail = new vendor_Ledger_detail;
        $remaining = $request->total_bill - $request->payment;
        
        $ledger_detail->fk_vendor_ledger_id = $request->vendor_ledger_id;
        $ledger_detail->total_amount = $request->total_bill;
        $ledger_detail->paid_amount = $request->payment;
        $ledger_detail->remaining_amount = $remaining;
        $ledger_detail->payment_date = date('Y-m-d');
        $ledger_detail->discount = $request->discount;
        $ledger_detail->vcourier_paid = $request->vcourier_paid;
        // dd($request);
        $ledger_detail->save();
        Session::flash('message', 'New Payment is added'); 
        Session::flash('alert-class', 'alert-success'); 
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vendor_ledger_detail  $vendor_ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function show(vendor_ledger_detail $vendor_ledger_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vendor_ledger_detail  $vendor_ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(vendor_ledger_detail $vendor_ledger_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vendor_ledger_detail  $vendor_ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vendor_ledger_detail $vendor_ledger_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vendor_ledger_detail  $vendor_ledger_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(vendor_ledger_detail $vendor_ledger_detail)
    {
        //
    }
}
