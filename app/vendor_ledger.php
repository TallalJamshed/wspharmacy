<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendor_ledger extends Model
{
    public function vendors(){
        return $this->belongsTo('App\vendor');
    }
    public function vendor_ledger_details(){
        return $this->hasMany('App\vendor_ledger_detail','fk_vendor_ledger_id');
    }

    public static function addinledger($request){
        $data = vendor_Ledger::where('fk_vendor_id',$request->fk_vendor_id)->first();
        if($data){
            $total = $data->total_purchase_amount + $request->total_price ;
            vendor_Ledger::where('fk_vendor_id',$request->fk_vendor_id)->update(['total_purchase_amount'=>$total]);
        }else{
        $ledger = new vendor_Ledger;
        $ledger->fk_vendor_id = $request->fk_vendor_id;
        $ledger->total_purchase_amount = $request->total_price;
        $ledger->save();
        }
    }
}
