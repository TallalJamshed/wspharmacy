<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected  $primaryKey = 'sale_id';
    protected $fillable = [
        "sale_invoice", "sale_agent", "total_sale" ,"fk_cust_id","sale_date","courier_service"
        ];

    public function sale_details()
    {
        return $this->hasMany('App\sale_detail');
    }
    public function customers(){
        return $this->belongsTo('App\customer');
    }
}
