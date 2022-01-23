<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // https://stackoverflow.com/questions/8252875/how-to-restrict-data-length-in-sqlite3
        DB::statement('CREATE TABLE IF NOT EXISTS "packs" ("id" integer not null primary key autoincrement, "name" text not null check(length(name) <= 30), "created_at" datetime, "updated_at" datetime);');
        DB::statement('CREATE UNIQUE INDEX "pack_name_unique" on "packs" ("name");)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packs');
    }
}
