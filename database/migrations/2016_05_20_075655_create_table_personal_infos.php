<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePersonalInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_infos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('age');
            $table->string('occupation')->nullable()->default(NULL);
            $table->enum('working_with_financial_advisor',['Yes','No'])->default(NULL);
            $table->enum('married',['Yes','No'])->nullable()->default(NULL);
            $table->string('spouse_name')->nullable()->default(NULL);
            $table->string('spouse_age')->nullable()->default(NULL);
            $table->text('children')->nullable()->default(NULL);
            $table->enum('retirement',['1','2','3','4','5'])->nullable()->default(NULL);
            $table->enum('long_term_care_planning',['1','2','3','4','5'])->nullable()->default(NULL);
            $table->enum('wealth_accumulation',['1','2','3','4','5'])->nullable()->default(NULL);
            $table->enum('college_planning',['1','2','3','4','5'])->nullable()->default(NULL);
            $table->enum('tax_estate_planning',['1','2','3','4','5'])->nullable()->default(NULL);
            $table->enum('debt_management',['1','2','3','4','5'])->nullable()->default(NULL);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('personal_infos');
    }
}
