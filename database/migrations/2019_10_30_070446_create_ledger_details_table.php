<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_details', function (Blueprint $table) {
            $table->bigIncrements('ledger_details_id');
            $table->string('fk_ledger_id');
            $table->bigInteger('total_amount');
            $table->bigInteger('paid_amount');
            $table->bigInteger('remaining_amount');
            $table->integer('discount');
            $table->integer('courier_paid');
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
        Schema::dropIfExists('ledger_details');
    }
}
