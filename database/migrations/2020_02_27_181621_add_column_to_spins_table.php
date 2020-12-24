<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSpinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spins', function (Blueprint $table) {
            $table->integer('pro_total')->default(0);
            $table->integer('pro_special')->default(0);
            $table->integer('special_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spins', function (Blueprint $table) {
            $table->dropColumn(['pro_total', 'pro_special', 'special_type']);
        });
    }
}
