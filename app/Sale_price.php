<?php

namespace App;
use Auth;
use Session;

use Illuminate\Database\Eloquent\Model;

class Sale_price extends Model
{
    protected $table = 'sale_prices';
    protected $primaryKey = 'price_id';
    protected $fillable = [
        'fk_med_id' , 'sale_price'
    ];

    public function medicines(){
        return $this->belongsTo('App\medicine');
    }
    public static function getPricing(){
        return sale_price::select('med_name' , 'sale_price')
                    ->join('medicines','medicines.med_id','sale_prices.fk_med_id')
                    ->get();
    }
    public static function storeData($request)
    {
        $pricing = sale_price::updateOrCreate(['fk_med_id'=>$request->fk_med_id] , [
            'sale_price' => $request->sale_price,
            ]);
    }
}
