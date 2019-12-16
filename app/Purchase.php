<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';
    protected  $primaryKey = 'purchase_id';
    protected $fillable = [
        "invoice_no", "fk_vendor_id", "total_price" , "purchase_agent" , "purchase_courier"
        ];

    public function purchase_details()
    {
        return $this->hasMany('App\purchase_detail','fk_purchase_id');
    }
}
