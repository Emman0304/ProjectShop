<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_branches', function (Blueprint $table) {
            $table->id();
            $table->string("BranchCode");
            $table->string("Description");
            $table->string("Address");
            $table->string("Manager")->nullable();
            $table->integer("NoEmployees");
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
        Schema::dropIfExists('tbl_branches');
    }
}
