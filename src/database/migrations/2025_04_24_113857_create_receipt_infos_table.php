<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_infos', function (Blueprint $table) {
            $table->id('receipt_id');
            $table->string('title');
            $table->string('image_url');
            $table->string('user_who_paid');
            $table->unsignedBigInteger('total_amount');
            $table->unsignedBigInteger('person_1_amount');
            $table->unsignedBigInteger('person_2_amount');
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
        Schema::dropIfExists('receipt_infos');
    }
}
