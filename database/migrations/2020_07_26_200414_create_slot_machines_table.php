<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('slots')->default('');
            $table->string('type');
            $table->integer('price')->default(0);
            $table->text('description')->default('');
            $table->integer('status')->default(1);
            $table->string('url');
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
        Schema::dropIfExists('slot_machines');
    }
}
