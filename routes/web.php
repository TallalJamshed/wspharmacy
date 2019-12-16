<?php

// Default Routes
Auth::routes();

// Home Page
Route::get('/', 'HomeController@create')->name('dashboard');
// // // // // // // // // // Custom routes // // // // // // // // // //

// Category Controller
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/addcategoryform', 'CategoryController@create')->name('addcategoryform');
Route::post('/addcategories','CategoryController@store')->name('addcategoriesindb');
Route::post('/deletecategory','CategoryController@destroy')->name('deletecategory');

// Company Controller
Route::get('/addcompanyform', 'CompanyController@create')->name('addcompanyform');
Route::post('/addcompany','CompanyController@store')->name('addcompanyindb');
Route::post('/deletecompany', 'CompanyController@destroy')->name('deletecompany');

// Customer Category Controller

// Customer Controller
// Route::get('/addcustform','CustomerController@create')->name('addcustform');
Route::post('/addcustomerindb','CustomerController@store')->name('addcustomerindb');
Route::post('/deletecustomer', 'CustomerController@destroy')->name('deletecustomer');
Route::post('/genrecovery', 'CustomerController@genrecoveryreport')->name('genrecoveryreport');


// Formula Controller
Route::get('/addformulaform', 'FormulaController@create')->name('addformulaform');
Route::post('/addformulaindb','FormulaController@store')->name('addformulaindb');
Route::post('/deleteformula','FormulaController@destroy')->name('deleteformula');

// Home Controller
Route::get('/genreportview', 'HomeController@genreport')->name('genreport');
Route::get('/plreportview', 'HomeController@genplreport')->name('plreport');
Route::get('/recoveryview', 'HomeController@recoveryreport')->name('recoveryreport');
Route::post('/plreport', 'HomeController@genplreportdata')->name('plreportdata');

// Ledger Controller
Route::get('/custpaymentform','LedgerController@create')->name('addcustpaymentform');
Route::post('/getbyinvoice','SaleController@getbyinvoice')->name('getbyinvoice');
Route::post('/getbycust','SaleController@getbycust')->name('getbycust');
Route::post('/addpayment','LedgerDetailController@store')->name('addpaymentindb');

// vendor ledger controller
Route::get('/vendorpaymentform','VendorLedgerController@create')->name('addvendorpaymentform');
Route::post('/getbyvendorinvoice','PurchaseController@getbyinvoice')->name('getbyvendorinvoice');
Route::post('/getbyvendor','PurchaseController@getbyvendor')->name('getbyvendor');
Route::post('/addvendorpayment','VendorLedgerDetailController@store')->name('addvendorpaymentindb');
// Ledger Details Controller

// Medicine Controller
Route::get('/addmedicineform', 'MedicineController@create')->name('addmedicineform');
Route::post('/addmedicine','MedicineController@store')->name('addmedicineindb');
Route::post('/deletemedicine','MedicineController@destroy')->name('deletemedicine');
Route::get('/getmedsdata/{id}','MedicineController@getMedsByFormula')->name('getmedsdata');

// Purchase Controller
Route::get('/addpurchaseform', 'PurchaseController@create')->name('addpurchaseform');
Route::post('/addpurchase','PurchaseController@store')->name('addpurchaseindb');
Route::post('/deletepurchase','PurchaseController@destroy')->name('deletepurchase');
Route::get('/purchaseform','PurchaseController@showPurchaseForm')->name('showpurchaseform');
Route::post('/genpurchasereport','PurchaseController@genpurchasereport')->name('genpurchasereport');
Route::get('/purchasereturn','PurchaseController@returnpurchaseview')->name('purchasereturn');
Route::post('/deletepurchase','PurchaseController@deletepurchase')->name('deletepurchase');
Route::post('/getpurchasebyinvoice','PurchaseController@getpurchasebyinvoice')->name('getpurchasebyinvoice');

// Purchase Detail Controller
Route::get('/addpurchasedetailsform', 'PurchaseDetailController@create')->name('addpurchasedetailsform');
Route::post('/addpurchasedetails','PurchaseDetailController@store')->name('addpurchasedetailsindb');
Route::post('/deletepurchasedetails','PurchaseDetailController@destroy')->name('deletepurchasedetails');
Route::get('/expiredmeds','PurchaseDetailController@getExpiredMeds')->name('expiredmeds');

Route::post('/getlastpurchase','PurchaseDetailController@getlastpurchase')->name('getlastpurchase');
Route::post('/getMeds','PurchaseDetailController@getMeds')->name('getMeds');

Route::post('/deletepurchase','PurchaseDetailController@deletePurchase')->name('deletepurchase');




// Role Controller

// vendor Controller
Route::get('/vendorform','VendorController@create')->name('addvendorform');
Route::post('/addvendor','VendorController@store')->name('addvendorindb');

// Sale Controller
Route::get('/allsales/{filter}','SaleController@showsales')->name('allsales');
Route::post('/gensalesreport','SaleController@gensalesreport')->name('gensalesreport');
Route::get('/salesform','SaleController@showSalesForm')->name('showsalesform');
Route::post('/gensaleinvoice','SaleController@gensaleinvoice')->name('gensaleinvoice');
Route::get('/addsalesform', 'SaleController@create')->name('addsalesform');
Route::post('/addsales','SaleController@store')->name('addsalesindb');
Route::get('/dailysalesreport', 'SaleController@showDailySales')->name('dailysalesreport');
Route::get('/topsalesreport', 'SaleController@showTopSales')->name('topsalesreport');

// Route::post('/deleteinvoice','SaleController@deleteinvoice')->name('deleteinvoice');
Route::post('/deletesales','SaleController@deletesales')->name('deletesales');

Route::get('/salesreturn','SaleController@returnsalesview')->name('salesreturn');
Route::post('/getsalebyinvoice','SaleController@getsalebyinvoice')->name('getsalebyinvoice');

Route::get('/testsale','SaleCOntroller@show')->name('testsale');
// Sale Detail Controller
Route::post('/getavgpurchase','SaleDetailController@getavgpurchase')->name('getavgpurchase');
Route::post('/getSaleMeds','SaleDetailController@getSaleMeds')->name('getSaleMeds');



// Sale Price Controller
Route::get('/addpricingform','SalePriceController@create')->name('addpricingform');
Route::post('/addpricingindb','SalePriceController@store')->name('addpricingindb');

// Stock Controller
Route::get('/stocks', 'StockController@create')->name('showstocks');
Route::post('/deletestock', 'StockController@destroy')->name('deletestock');
Route::get('/printstocks', 'StockController@printstocks')->name('printstocks');

