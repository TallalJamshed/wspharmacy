<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    protected $table = 'vendors';
    protected  $primaryKey = 'vendor_id';
    protected $fillable = [
        "vendor_name"
        ];
    public static function getVendors(){
        return vendor::get();
    }
}