<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SubnetIps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subnet_ips', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->increments('id');
            $t->integer('subnet_id')->unsigned();
            $t->integer('ip')->unsigned();
            $t->integer('user_id')->unsigned()->nullable();
            $t->timestamp('assigned_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subnet_ips');
    }
}
