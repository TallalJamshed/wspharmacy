<?php

namespace App;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'cust_id';
    protected $fillable = [
        'cust_name' , 'cust_email' ,'cust_phoneno', 'cust_address'
    ];

    public function sales()
    {
        return $this->hasMany('App\sale' , 'fk_cust_id');
    }
    public function ledgers()
    {
        return $this->hasOne('App\ledger' , 'fk_cust_id');
    }
    public static function getCustomers(){
        return Customer::get();
    }
    public static function saveData($request){
        $customer = new Customer;
        $customer->fill($request->all());
        $customer->fk_cust_cat_id = $request->fk_cust_cat_id;
        $customer->save();
    }
    public static function deleteData($request){
        Customer::where('cust_id',$request->cust_id)->delete();
    }
}
