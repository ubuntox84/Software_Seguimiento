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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->index()->unique();
            $table->string('name',200)->index();
            $table->string('theoretic_hour',10)->nullable();
            $table->string('practical_hour',10)->nullable();
            $table->string('prerequisite',10)->nullable();
            $table->string('type_course',100)->index()->nullable();
            $table->string('university_law',100)->index()->nullable();
            $table->integer('credits')->nullable();
            $table->integer('cycle')->nullable();

         
            $table->unsignedBigInteger('area_knowledge_id')->nullable();
            $table->foreign('area_knowledge_id')
                    ->references('id')
                    ->on('area_knowledge')
                    ->onDelete('restrict');

            $table->unsignedBigInteger('curricula_id')->nullable();
            $table->foreign('curricula_id')
                    ->references('id')
                    ->on('curriculas')
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
        Schema::dropIfExists('courses');
    }
};
