<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected  $primaryKey = 'cat_id';
    protected $fillable = [
        "cat_name"
        ];

    public function medicines()
    {
        return $this->hasMany('App\medicine' , 'fk_cat_id');
    }

    public static function getCat(){
        return category::get();
    }
    public static function storeData($request){
        $category = new category;
        $category->fill($request->all());
        $category->save();
    }
    public static function deleteData($request){
        category::where('cat_id',$request->cat_id)->delete();
    }
}
