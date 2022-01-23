<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWolfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         Schema::create('wolf', function (Blueprint $table) {
//             $table->id();
//             $table->string('name', 30)->unique();
//             $table->string('birth', 10)->change();
//             $table->string('gender', 1)->nullable();
//             $table->timestamps();
//         });

        // https://stackoverflow.com/questions/8252875/how-to-restrict-data-length-in-sqlite3
        DB::statement('CREATE TABLE IF NOT EXISTS "wolf" ("id" integer not null primary key autoincrement, "name" text not null check(length(name) <= 30), "gender" text check(length(gender) <= 1) , "birth" text not null check(length(birth) <= 10), "created_at" datetime, "updated_at" datetime);');
        DB::statement('CREATE UNIQUE INDEX "wolf_name_unique" on "wolf" ("name");)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wolf');
    }
}
