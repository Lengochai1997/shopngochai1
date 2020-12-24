<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSlotMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slot_machines', function (Blueprint $table) {
            $table->string('model')->default('normal');
            $table->string('background')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slot_machines', function (Blueprint $table) {
            $table->dropColumn('model');
            $table->dropColumn('background');
        });
    }
}
