<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_mapping', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('day_type');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('price_mapping_btype', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->foreign('id')->references('id')->on('price_mapping')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('btype_id');
            $table->foreign('btype_id')->references('id')->on('booking_type')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_mapping');
        Schema::dropIfExists('price_mapping_btype');
    }
}
