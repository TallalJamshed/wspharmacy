<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    protected $table = 'formulas';
    protected  $primaryKey = 'formula_id';
    protected $fillable = [
        "formula_name"
        ];

    public function medicines()
    {
        return $this->hasMany('App\medicines' , 'fk_formula_id');
    }
    public static function getFormula()
    {
        return formula::get();
    }
    public static function storeData($request)
    {
        $formula = new formula;
        $formula->fill($request->all());
        $formula->formula_name = strtoupper($request->formula_name);
        $formula->save();
    }
    public static function deleteData($request)
    {
        formula::where('formula_id',$request->formula_id)->delete();
    }
}
