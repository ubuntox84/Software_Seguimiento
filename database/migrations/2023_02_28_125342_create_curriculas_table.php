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
            Schema::create('curriculas', function (Blueprint $table) {
            $table->id();
            $table->string("name",200)->index()->unique();
            $table->string("resolution",100)->nullable()->index()->unique();
            $table->string('code',10)->index()->unique();
            $table->string('profesional_school',200)->nullable();
            $table->string('semester_start',20)->nullable();
            $table->integer('compulsory')->nullable();
            $table->integer('elective')->nullable();
            $table->integer('free_activity')->nullable();
            $table->integer('pre_professional_practice')->nullable();

            $table->tinyInteger('state')->default(1);
            $table->date("date_approved")->nullable();
            $table->date("date_active")->nullable();
            $table->date("date_inactive")->nullable();

            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->foreign('faculty_id')
                    ->references('id')
                    ->on('faculties')
                    ->onDelete('restrict');
             $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')
                    ->references('id')
                    ->on('departments')
                    ->onDelete('restrict'); 

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
        Schema::dropIfExists('curriculas');
    }
};
