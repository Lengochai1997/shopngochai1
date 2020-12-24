<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInSpinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spins', function (Blueprint $table) {
            $table->string('title')->default('');
            $table->text('rules')->default('');
            $table->text('description')->default('');
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
            $table->dropColumn(['title']);
            $table->dropColumn(['rules']);
            $table->dropColumn(['description']);
        });
    }
}
