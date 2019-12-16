<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorLedgerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_ledger_details', function (Blueprint $table) {
            $table->bigIncrements('vendor_ledger_details_id');
            $table->string('fk_vendor_ledger_id');
            $table->bigInteger('total_amount');
            $table->bigInteger('paid_amount');
            $table->bigInteger('remaining_amount');
            $table->Integer('vcourier_paid');
            $table->Integer('discount');
            $table->date('payment_date');
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
        Schema::dropIfExists('vendor_ledger_details');
    }
}
