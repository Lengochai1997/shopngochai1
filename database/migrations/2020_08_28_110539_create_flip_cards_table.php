<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlipCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flip_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('image')->default('');
            $table->string('title');
            $table->string('url');
            $table->text('slots')->default('');
            $table->integer('price')->default(0);
            $table->text('rules')->default('');
            $table->text('description')->default('');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('flip_cards');
    }
}
