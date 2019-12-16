<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendor_ledger_detail extends Model
{
    protected $table = 'vendor_ledger_details';
    protected  $primaryKey = 'vendor_ledger_details_id';
    protected $fillable = [
        "fk_vendor_ledger_id" , "total_amount" , "paid_amount" , "remaining_amount" , "payment_date" , "discount" , "vcourier_paid"
        ];
    
    public function vendor_ledgers()
    {
        return $this->belongsTo('App\vendor_ledger');
    }
}
