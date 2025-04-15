<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ranking_categories_id');
            $table->integer('rank_number');
            $table->string('title');
            $table->string('image_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rank_info');
    }
}
