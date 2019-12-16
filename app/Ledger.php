<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    
    public function customers(){
        return $this->belongsTo('App\customer');
    }
    public function ledger_details(){
        return $this->hasMany('App\ledger_detail','fk_ledger_id');
    }

    public static function addinledger($request){
        $data = Ledger::where('fk_cust_id',$request->fk_cust_id)->first();
        if($data){
            $total = $data->total_sales_amount + $request->total_sale ;
            Ledger::where('fk_cust_id',$request->fk_cust_id)->update(['total_sales_amount'=>$total]);
        }else{
        $ledger = new Ledger;
        $ledger->fk_cust_id = $request->fk_cust_id;
        $ledger->total_sales_amount = $request->total_sale;
        $ledger->save();
        }
    }
}
