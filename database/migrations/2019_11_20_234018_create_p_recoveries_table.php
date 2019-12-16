<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePRecoveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_recoveries', function (Blueprint $table) {
            $table->bigIncrements('p_recovery_id');
            $table->integer('fk_purchase_detail_id');
            $table->integer('p_recovered_amount');
            $table->integer('p_unit_price');
            $table->date('p_recovery_date');
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
        Schema::dropIfExists('p_recoveries');
    }
}
