<?php

namespace App;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected  $primaryKey = 'stock_id';
    protected $fillable = [
        "fk_med_id", "total_quantity"
        ];

    public function medicines(){
        return $this->belongsTo('App\medicine');
    }

    public static function getMedsByStock()
    {
        return stock::select('med_id','company_name','med_name','stock_id','stocks.created_at')
                        ->join('medicines','stocks.fk_med_id','medicines.med_id')
                        ->join('companies','medicines.fk_company_id','companies.company_id')
                        ->get();
    }
}
