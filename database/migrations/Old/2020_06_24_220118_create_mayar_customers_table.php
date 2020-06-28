<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMayarCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mayar_customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->String("CustFirstName");
            $table->String("CustLastName");
            $table->String("CustMail");
            $table->String("CustUserName");
            $table->String("CustPass");
            $table->String("CustCountry");
            $table->String("CustAddress");
            $table->String("CustStatus");
            $table->String("CustActivationToken");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mayar_customers');
    }
}
