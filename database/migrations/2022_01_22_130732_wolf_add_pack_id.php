<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WolfAddPackId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $table->foreignIdFor('packs')->nullable();
        Schema::table('wolf', function (Blueprint $table) {
            $table->foreignId('pack_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If your application is utilizing an SQLite database, 
        // you must install the doctrine/dbal package via the Composer package manager
        // before the dropColumn method may be used
        
        Schema::table('wolf', function (Blueprint $table) {
            $table->dropColumn('pack_id');
        });
    }
}
