<?php
    use App\sale;
    use App\purchase_detail;
    use App\stock;
    use App\company;
    use App\expiry;
    use App\purchase;
    // use Auth;
    
    class Helper {

        public static function cardData() {
            
            // $sales = sales::count();
            // $expires = purchase_detail::where('expiry_date','<',date('Y-m-d'))->count();
            // $stocks = stock::join('medicines','stocks.fk_med_id','=','medicines.med_id')->join('companies','medicines.fk_company_id','=','companies.company_id')->join('categories','categories.cat_id','=','medicines.fk_med_cat_id')->join('purchase_details','purchase_details.fk_med_id','=','medicines.med_id')->join('purchases','purchase_details.fk_purchase_id','=','purchases.purchase_id')->groupBy('medicines.med_id')->get();
            $data = array(
                // "companies" => company::count(),
                "purchases" => purchase::count(), 
                "sales" => sale::count(),
                "expires" => purchase_detail::where('expiry','<',date('Y-m-d'))->where('expiry_shown',0)->count(),
                "stocks" => stock::join('medicines','stocks.fk_med_id','=','medicines.med_id')->join('companies','medicines.fk_company_id','=','companies.company_id')->join('categories','categories.cat_id','=','medicines.fk_cat_id')->join('purchase_details','purchase_details.fk_med_id','=','medicines.med_id')->join('purchases','purchase_details.fk_purchase_id','=','purchases.purchase_id')->groupBy('medicines.med_id')->get(),
            );
            // $stocks = stocks::get();
            // return $data->with('stocks',$stocks)->with('sales',$sales)->with('expires',$expires);
            return $data;
        }
    }
?>