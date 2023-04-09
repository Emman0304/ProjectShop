<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees', function (Blueprint $table) {
            $table->id();
            $table->string('LName');
            $table->string('FName');
            $table->string('MName');
            $table->string('Suffix');
            $table->integer('Age');
            $table->string('Address');
            $table->string('ContactNo');
            $table->string('Email');           
            $table->string('BranchCode');
            $table->string('Position');
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
        Schema::dropIfExists('tbl_employees');
    }
}
