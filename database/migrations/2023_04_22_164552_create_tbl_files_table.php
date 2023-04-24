<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_files', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('name');
            $table->string('type');
            $table->string('size');
            $table->binary('data')->nullable(); # change manually the data type of column from blob to longblob.
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
        Schema::dropIfExists('tbl_files');
    }
}
