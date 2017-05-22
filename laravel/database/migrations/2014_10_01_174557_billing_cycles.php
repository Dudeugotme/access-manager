<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class BillingCycles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_cycles', function (Blueprint $t) {
            $t->engine = 'InnoDB';

            $t->increments('id');
            $t->integer('user_id')->unsigned();
            $t->integer('billing_cycle')->unsigned();
            $t->enum('billing_unit', ['Months', 'Years']);
            $t->timestamp('last_billied_on')->nullable();
            $t->integer('bill_date')->unsigned();
            $t->timestamp('expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_cycles');
    }
}
