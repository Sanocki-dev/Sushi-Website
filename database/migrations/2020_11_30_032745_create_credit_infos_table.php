<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_credit_info', function (Blueprint $table) {
            $table->increments('credit_id');
            $table->integer('user_id');
            $table->integer('pay_id');
            $table->string('name');
            $table->string('number');
            $table->date('exp_Date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_credit_info');
    }
}
