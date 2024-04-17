<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('university')->notNullable();
            $table->string('director')->notNullable();
            $table->string('commission_name')->notNullable();
            $table->string('abbreviation')->notNullable();
            $table->string('city'); 
             $table->integer('agreement_number');
            $table->string('semester', 50); 
            $table->string('president_name'); 
            $table->binary('logo_path');
            
            $table->string('left_image')->notNullable();
            $table->string('right_image')->notNullable();

            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('configurations');
    }
};
