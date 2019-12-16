<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Purchase_detail extends Model
{
    protected $table = 'purchase_details';
    protected  $primaryKey = 'purchase_detail_id';
    protected $fillable = [
        "fk_purchase_id", "fk_med_id" , "unit_quantity", "subunit_quantity", "unit_price", "subunit_price", "expiry"
        ];

    public function medicines()
    {
        return $this->belongsTo('App\medicine');
    }
    public function purchases()
    {
        return $this->belongsTo('App\purchase');
    }
    // public function sale_price()
    // {
    //     return $this->hasOne('App\sale_price');
    // }
    public static function getPurchaseDetail(){
        return purchase_detail::select('med_id','company_name','med_name','price_per_unit','purchase_details.created_at')
                                ->join('medicines','purchase_details.fk_med_id','medicines.med_id')
                                ->join('companies','medicines.fk_company_id','companies.company_id')
                                ->join('purchases','purchase_details.fk_purchase_id','purchases.purchase_id')
                                ->groupBy('med_name')
                                ->get();
    }
}
