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
            // TODO: rank_number should be a NUMBER???
            $table->integer('rank_number');
            $table->string('title');
            $table->string('image_url');
            // TODO: Is it important to have timestamps???
            // $table->timestamps();
            // TODO: 以下のforeign()がうまくいかない・・・
            // $table->foreign('ranking_categories_id')->references('id')->on('ranking_categories');
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
