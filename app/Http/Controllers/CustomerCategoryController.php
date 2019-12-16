<?php

namespace App\Http\Controllers;

use App\Customer_category;
use Illuminate\Http\Request;

class CustomerCategoryController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer_category  $customer_category
     * @return \Illuminate\Http\Response
     */
    public function show(Customer_category $customer_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer_category  $customer_category
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer_category $customer_category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer_category  $customer_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer_category $customer_category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer_category  $customer_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer_category $customer_category)
    {
        //
    }
}
