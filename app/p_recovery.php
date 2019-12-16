<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class p_recovery extends Model
{
    protected $table = 'p_recoveries';
    protected  $primaryKey = 'p_recovery_id';
    protected $fillable = [
        "fk_purchase_detail_id", "p_recovered_amount" , "p_unit_price", "p_recovery_date"
        ];
}
