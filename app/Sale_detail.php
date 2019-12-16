<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale_detail extends Model
{
    protected $table = 'sale_details';
    protected  $primaryKey = 'sale_detail_id';
    protected $fillable = [
        "fk_sale_id", "fk_med_id" , "quantity_sold", "price"
        ];

    public function sales()
    {
        return $this->belongsTo('App\sale');
    }
}
