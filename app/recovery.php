<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recovery extends Model
{
    protected $table = 'recoveries';
    protected  $primaryKey = 'recovery_id';
    protected $fillable = [
        "fk_sale_detail_id", "recovered_amount" , "unit_price", "recovery_date"
        ];

}
