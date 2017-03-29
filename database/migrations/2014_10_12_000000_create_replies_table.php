<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
             $table->string('title',100);
            $table->text('message');
            $table->integer('message_id')->unsigned();
            
            $table->integer('receiver_id')->unsigned();
            $table->integer('sender_id')->unsigned();
             $table->tinyInteger('importance')->default(0);
           
            
            $table->timestamps();
        });
        Schema::table('replies', function (Blueprint $table) {
           $table->foreign('message_id')->references('id')->on('messages');
            $table->foreign('receiver_id')->references('id')->on('users');
           $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
