<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_category extends Model
{
    protected $table = 'customer_categories';
    protected  $primaryKey = 'cust_cat_id';
    protected $fillable = [
        "cust_cat_name"
        ];

    public static function getCat(){
        return Customer_category::get();
    }
}
