<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Todo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id');
            $table->bigInteger('in_charge_id');
            $table->longText('description');
            $table->boolean('done')->default(false);
            $table->timestamps();
           
        });

        /*
        Schema::table('todos', function($table) {
            $table->foreign('owner_id')->references('id')->on('employee')->onDelete('cascade');
            $table->foreign('in_charge_id')->references('id')->on('employee')->onDelete('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
