<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpinCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spin_coins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->text('properties')->nullable();
            $table->text('ratio')->nullable();
            $table->integer('price')->default(0);
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable();
            $table->text('rules')->nullable();
            $table->text('description')->nullable();
            $table->integer('total')->default(0);
            $table->integer('count_turn')->default(0);
            $table->integer('pro_total')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('spin_coins');
    }
}
