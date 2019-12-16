<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->bigIncrements('purchase_detail_id');
            $table->string('fk_purchase_id');
            $table->string('fk_med_id');
            $table->string('unit_quantity');
            $table->string('subunit_quantity');
            $table->string('unit_price');
            $table->string('subunit_price');
            $table->date('purchasedetail_date');
            $table->date('expiry');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
}
