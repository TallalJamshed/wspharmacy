<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected  $primaryKey = 'company_id';
    protected $fillable = [
        "company_name"
        ];

    public function medicines()
    {
        return $this->hasMany('App\medicine' , 'fk_company_id');
    }

    public static function getCompany(){
        return company::get();
    }
    public static function storeData($request){
        $company = new company;
        $company->fill($request->all());
        $company->save();
    }
    public static function deleteData($request){
        company::where('company_id',$request->company_id)->delete();
    }
}
