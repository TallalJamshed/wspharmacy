<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger_detail extends Model
{
    protected $table = 'ledger_details';
    protected  $primaryKey = 'ledger_details_id';
    protected $fillable = [
        "fk_ledger_id" , "total_amount" , "paid_amount" , "remaining_amount" , "payment_date" , "discount" ,"courier_paid"
        ];
    
    public function ledgers()
    {
        return $this->belongsTo('App\ledger');
    }
}
