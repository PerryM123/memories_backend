<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_info', function (Blueprint $table) {
            $table->timestamps();
            $table->id('post_info_id');
            $table->unsignedBigInteger('user_id');
            $table->string('message_title');
            $table->string('message_text');
            // TODO: Post date needs to be changed for UTC time
            $table->string('post_date');
            $table->string('frame_type');
            $table->boolean('is_edited');
            $table->boolean('is_deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_info');
    }
}
