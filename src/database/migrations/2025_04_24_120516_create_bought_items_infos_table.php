<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoughtItemsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bought_items_infos', function (Blueprint $table) {
            $table->id('bought_item_id');
            $table->unsignedBigInteger('receipt_id');
            $table->string('name');
            $table->unsignedBigInteger('price');
            $table->string('payer_name');
            $table->timestamps();

            $table->foreign('receipt_id')
                ->references('receipt_id')
                ->on('receipt_infos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bought_items_infos');
    }
}
