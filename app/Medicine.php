<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';
    protected  $primaryKey = 'med_id';
    protected $fillable = [
        "med_name", "fk_company_id" , "fk_cat_id", "fk_formula_id"
        ];

    public function companies()
    {
        return $this->belongsTo('App\company');
    }
    public function categories()
    {
        return $this->belongsTo('App\category');
    }
    public function formulas()
    {
        return $this->belongsTo('App\formula');
    }
    public function purchase_details()
    {
        return $this->hasMany('App\purchase_detail' , 'fk_med_id');
    }
    public function sale_prices()
    {
        return $this->hasOne('App\sale_price' , 'fk_med_id');
    }
    public function stocks()
    {
        return $this->hasOne('App\stock' , 'fk_med_id');
    }

    public static function getMedicine()
    {
        return $medicines = medicine::join('companies','companies.company_id','=','medicines.fk_company_id')
                                        ->join('categories','categories.cat_id','=','medicines.fk_cat_id')
                                        ->join('formulas','medicines.fk_formula_id','=','formulas.formula_id')
                                        ->get();
    }
    public static function storeData($request)
    {
        $medicine = new medicine;
        $medicine->fill($request->all());
        $medicine->med_name = strtoupper($request->med_name);
        $medicine->save();
    }
    public static function deleteData($request)
    {
        medicine::where('med_id',$request)->delete();
    }
}
