<?php

namespace App\Http\Controllers;

use App\vendor_ledger;
use App\vendor;
use Illuminate\Http\Request;

class VendorLedgerController extends Controller
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
        $vendors = vendor::join('purchases','purchases.fk_vendor_id','vendors.vendor_id')->groupBy('purchases.fk_vendor_id')->get();
        return view('payment.vendorpayment_form')->with('vendors',$vendors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vendor_ledger  $vendor_ledger
     * @return \Illuminate\Http\Response
     */
    public function show(vendor_ledger $vendor_ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vendor_ledger  $vendor_ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(vendor_ledger $vendor_ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vendor_ledger  $vendor_ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vendor_ledger $vendor_ledger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vendor_ledger  $vendor_ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy(vendor_ledger $vendor_ledger)
    {
        //
    }
}
