<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('c_name');
            $table->integer('c_number');
            $table->text('c_address')->nullable();
            $table->timestamps();
        });

        Schema::create('booking', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pm_id');
            $table->foreign('pm_id')->references('id')->on('price_mapping')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('c_id');
            $table->foreign('c_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('h_total',10, 2);
            $table->decimal('add_total', 10, 2);
            $table->tinyInteger('day_type');
            $table->tinyInteger('active');
            $table->date('b_date');
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamps();
            $table->unique(array('pm_id','b_date','day_type'));
        });

         Schema::create('booking_addon', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->foreign('id')->references('id')->on('booking')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('addon_id');
        });

         Schema::create('booking_payment', function (Blueprint $table) {
            $table->increments('bpid');
            $table->unsignedInteger('id');
            $table->foreign('id')->references('id')->on('booking')->onDelete('cascade')->onUpdate('cascade');
            $table->date('paid_date');
            $table->tinyInteger('payment_type');
            $table->decimal('amount', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
        Schema::dropIfExists('booking');
        Schema::dropIfExists('booking_addon');
        Schema::dropIfExists('booking_payment');
    }
}
